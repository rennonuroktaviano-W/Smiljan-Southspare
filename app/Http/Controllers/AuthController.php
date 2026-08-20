<?php

namespace App\Http\Controllers;

use App\Http\Traits\HoneypotProtection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    use HoneypotProtection;

    public function login(): View
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => mb_strtolower(trim((string) $request->input('email'))),
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $lockoutKey = 'login-lockout:'.$request->input('email').'|'.$request->ip();
        $maxAttempts = (int) config('admin.security.login_lockout_attempts', 5);
        $lockoutMinutes = (int) config('admin.security.login_lockout_minutes', 15);

        if (RateLimiter::tooManyAttempts($lockoutKey, $maxAttempts)) {
            $minutes = (int) ceil(RateLimiter::availableIn($lockoutKey) / 60);

            activity()
                ->withProperties(['email' => $request->input('email'), 'ip' => $request->ip()])
                ->event('login_locked')
                ->log('Akun terkunci sementara karena terlalu banyak percobaan');

            return back()
                ->withErrors(['email' => 'Terlalu banyak percobaan login. Coba lagi dalam '.$minutes.' menit.'])
                ->onlyInput('email');
        }

        if ($this->honeypotFilled($request)) {
            activity()
                ->withProperties(['email' => $request->input('email'), 'ip' => $request->ip()])
                ->event('honeypot')
                ->log('Bot terdeteksi pada form login');

            return back()->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ])->onlyInput('email');
        }

        if (! Auth::attempt($credentials)) {
            RateLimiter::hit($lockoutKey, $lockoutMinutes * 60);

            activity()
                ->withProperties(['email' => $request->input('email'), 'ip' => $request->ip()])
                ->event('login_failed')
                ->log('Percobaan login gagal');

            return back()->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ])->onlyInput('email');
        }

        RateLimiter::clear($lockoutKey);

        $user = Auth::user();
        session(['two_factor_pending' => $user->id]);

        activity()
            ->performedOn($user)
            ->event('login_2fa_pending')
            ->withProperties(['ip' => $request->ip()])
            ->log('Login menunggu verifikasi 2FA');

        return $user->two_factor_enabled
            ? redirect()->route('admin.two-factor.challenge')
            : redirect()->route('admin.two-factor.setup');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            activity()
                ->performedOn($user)
                ->event('logout')
                ->log('Logout');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
