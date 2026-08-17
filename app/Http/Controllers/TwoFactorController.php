<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function showChallenge(): View
    {
        return view('admin.auth.two-factor-challenge');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string', 'digits:6']]);

        $pendingUserId = session('two_factor_pending');

        if (! $pendingUserId) {
            return redirect()->route('admin.login');
        }

        $user = User::findOrFail($pendingUserId);
        $google2fa = new Google2FA;

        if ($google2fa->verifyKey(decrypt($user->two_factor_secret), $request->input('code'))) {
            Auth::login($user);
            $request->session()->regenerate();
            session()->forget('two_factor_pending');
            session(['two_factor_verified' => true]);

            activity()
                ->performedOn($user)
                ->event('login')
                ->withProperties(['ip' => $request->ip(), 'user_agent' => $request->userAgent()])
                ->log('Login berhasil (2FA verified)');

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['code' => 'Kode verifikasi salah.']);
    }

    public function showSetup(): View
    {
        $user = Auth::user();
        $google2fa = new Google2FA;

        $secret = $google2fa->generateSecretKey();
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('admin.two-factor.setup', [
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    public function enable(Request $request): RedirectResponse
    {
        $request->validate(['secret' => ['required', 'string'], 'code' => ['required', 'string', 'digits:6']]);

        $google2fa = new Google2FA;

        if (! $google2fa->verifyKey($request->input('secret'), $request->input('code'))) {
            return back()->withErrors(['code' => 'Kode verifikasi salah. Coba lagi.']);
        }

        Auth::user()->two_factor_enabled = true;
        Auth::user()->two_factor_secret = encrypt($request->input('secret'));
        Auth::user()->save();

        activity()
            ->performedOn(Auth::user())
            ->event('two_factor_enabled')
            ->log('2FA diaktifkan');

        return redirect()->route('admin.profile.edit')->with('ok', '2FA berhasil diaktifkan.');
    }

    public function disable(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'string']]);

        if (! Hash::check($request->input('password'), Auth::user()->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        Auth::user()->two_factor_enabled = false;
        Auth::user()->two_factor_secret = null;
        Auth::user()->save();

        session()->forget('two_factor_verified');

        activity()
            ->performedOn(Auth::user())
            ->event('two_factor_disabled')
            ->log('2FA dinonaktifkan');

        return redirect()->route('admin.profile.edit')->with('ok', '2FA berhasil dinonaktifkan.');
    }
}
