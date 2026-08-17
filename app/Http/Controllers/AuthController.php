<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            activity()
                ->withProperties(['email' => $request->input('email'), 'ip' => $request->ip()])
                ->event('login_failed')
                ->log('Percobaan login gagal');

            return back()->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        if ($user->two_factor_enabled) {
            session(['two_factor_pending' => $user->id]);

            activity()
                ->performedOn($user)
                ->event('login_2fa_pending')
                ->withProperties(['ip' => $request->ip()])
                ->log('Login menunggu verifikasi 2FA');

            return redirect()->route('admin.two-factor.challenge');
        }

        $request->session()->regenerate();

        activity()
            ->performedOn($user)
            ->event('login')
            ->withProperties(['ip' => $request->ip(), 'user_agent' => $request->userAgent()])
            ->log('Login berhasil');

        return redirect()->intended(route('admin.dashboard'));
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
