<?php

namespace App\Http\Controllers;

use App\Mail\SecurityAlertMail;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function showChallenge(): View
    {
        return view('admin.auth.two-factor-challenge');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string', 'max:20']]);

        $pendingUserId = session('two_factor_pending');

        if (! $pendingUserId) {
            return redirect()->route('admin.login');
        }

        $user = User::findOrFail($pendingUserId);
        $code = trim($request->input('code'));

        $valid = false;

        if (preg_match('/^\d{6}$/', $code)) {
            $google2fa = new Google2FA;
            $valid = $google2fa->verifyKey(
                $user->two_factor_secret,
                $code,
                (int) config('admin.two_factor.window'),
            );
        } elseif ($user->two_factor_enabled && $user->verifyRecoveryCode($code)) {
            $valid = true;
        }

        if ($valid) {
            return $this->completeLogin($request, $user);
        }

        activity()
            ->performedOn($user)
            ->event('two_factor_failed')
            ->withProperties(['ip' => $request->ip()])
            ->log('Kode verifikasi 2FA salah');

        return back()->withErrors(['code' => 'Kode salah atau kedaluwarsa. Buka aplikasi autentikator dan gunakan kode terbaru (pastikan jam ponsel Anda akurat).']);
    }

    public function showSetup(): View|RedirectResponse
    {
        $pendingUserId = session('two_factor_pending');
        $user = $pendingUserId ? User::find($pendingUserId) : Auth::user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $pendingUserId && $user->two_factor_enabled && session('two_factor_verified')) {
            return redirect()->route('admin.profile.edit');
        }

        $google2fa = new Google2FA;

        $secret = session('two_factor_pending_secret');
        if (! $secret) {
            $secret = $google2fa->generateSecretKey();
            session(['two_factor_pending_secret' => $secret]);
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('admin.two-factor.setup', [
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl,
            'forced' => (bool) $pendingUserId,
        ]);
    }

    public function enable(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string', 'digits:6']]);

        $pendingUserId = session('two_factor_pending');
        $user = $pendingUserId ? User::findOrFail($pendingUserId) : Auth::user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        $secret = session('two_factor_pending_secret');
        if (! $secret) {
            return redirect()->route('admin.two-factor.setup')
                ->withErrors(['code' => 'Sesi berubah. Pindai ulang kode QR di bawah dan masukkan kode terbaru.']);
        }

        $google2fa = new Google2FA;

        if (! $google2fa->verifyKey(
            $secret,
            $request->input('code'),
            (int) config('admin.two_factor.window'),
        )) {
            return back()->withErrors(['code' => 'Kode salah atau kedaluwarsa. Buka aplikasi autentikator dan gunakan kode terbaru.']);
        }

        $user->two_factor_enabled = true;
        $user->two_factor_secret = $secret;
        $user->save();

        activity()
            ->performedOn($user)
            ->event('two_factor_enabled')
            ->log('2FA diaktifkan');

        session()->forget('two_factor_pending_secret');

        $recoveryCodes = $user->regenerateRecoveryCodes();

        return redirect()->route('admin.two-factor.recovery')
            ->with('recovery_codes', $recoveryCodes);
    }

    public function showRecovery(): View|RedirectResponse
    {
        $codes = session('recovery_codes');

        if (! $codes) {
            return redirect()->route('admin.profile.edit');
        }

        session()->reflash();

        return view('admin.two-factor.recovery', ['codes' => $codes]);
    }

    public function confirmRecovery(Request $request): RedirectResponse
    {
        if (! session('recovery_codes')) {
            return redirect()->route('admin.profile.edit');
        }

        $pendingUserId = session('two_factor_pending');
        $user = $pendingUserId ? User::find($pendingUserId) : Auth::user();

        session()->forget('recovery_codes');

        if ($user && $pendingUserId) {
            return $this->completeLogin($request, $user);
        }

        return redirect()->route('admin.profile.edit')->with('ok', '2FA berhasil diaktifkan.');
    }

    public function disable(Request $request): RedirectResponse
    {
        if (config('admin.two_factor.required', true)) {
            activity()
                ->performedOn(Auth::user())
                ->event('two_factor_disable_blocked')
                ->withProperties(['ip' => $request->ip()])
                ->log('Percobaan menonaktifkan 2FA diblokir');

            return back()->withErrors(['password' => '2FA wajib aktif untuk semua akun admin dan tidak dapat dinonaktifkan melalui web. Hubungi administrator untuk reset darurat.']);
        }

        $request->validate(['password' => ['required', 'string']]);

        if (! Hash::check($request->input('password'), Auth::user()->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        Auth::user()->two_factor_enabled = false;
        Auth::user()->two_factor_secret = null;
        Auth::user()->two_factor_recovery_codes = null;
        Auth::user()->save();

        session()->forget('two_factor_verified');

        activity()
            ->performedOn(Auth::user())
            ->event('two_factor_disabled')
            ->log('2FA dinonaktifkan');

        Mail::to(Auth::user()->email)->queue(new SecurityAlertMail(
            '2FA dinonaktifkan pada akun admin Anda',
            $request->ip(),
            $request->userAgent(),
        ));

        return redirect()->route('admin.profile.edit')->with('ok', '2FA berhasil dinonaktifkan.');
    }

    private function completeLogin(Request $request, User $user): RedirectResponse
    {
        Auth::login($user);
        $request->session()->regenerate();
        session()->forget(['two_factor_pending', 'two_factor_pending_secret', 'recovery_codes']);
        session(['two_factor_verified' => true]);

        $isNewDevice = $user->last_login_ip !== null && $user->last_login_ip !== $request->ip();

        if ($user->last_login_ip === null || $isNewDevice) {
            Mail::to($user->email)->queue(new SecurityAlertMail(
                $isNewDevice
                    ? 'Login baru terdeteksi pada akun admin Anda'
                    : 'Login pertama terdeteksi pada akun admin Anda',
                $request->ip(),
                $request->userAgent(),
            ));
        }

        $user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->save();

        activity()
            ->performedOn($user)
            ->event('login')
            ->withProperties(['ip' => $request->ip(), 'user_agent' => $request->userAgent()])
            ->log('Login berhasil (2FA verified)');

        return redirect()->intended(route('admin.dashboard'));
    }
}
