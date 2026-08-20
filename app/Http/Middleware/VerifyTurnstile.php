<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyTurnstile
{
    public function handle(Request $request, Closure $next): Response
    {
        $config = config('services.turnstile');

        if (! ($config['enabled'] ?? false)) {
            return $next($request);
        }

        if (($config['skip_local'] ?? true) && app()->environment('local')) {
            return $next($request);
        }

        $token = trim((string) $request->input('cf-turnstile-response'));

        if ($token === '' || ! ($config['secret_key'] ?? null)) {
            return $this->fail($request);
        }

        try {
            $response = Http::asForm()
                ->timeout(10)
                ->post($config['verification_url'], [
                    'secret' => $config['secret_key'],
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ]);
        } catch (\Throwable) {
            return $this->fail($request);
        }

        $data = $response->json();

        if (! $response->successful() || ! ($data['success'] ?? false)) {
            return $this->fail($request);
        }

        return $next($request);
    }

    private function fail(Request $request): Response
    {
        activity()
            ->withProperties(['ip' => $request->ip(), 'user_agent' => $request->userAgent()])
            ->event('captcha_failed')
            ->log('Verifikasi CAPTCHA gagal');

        return back()
            ->withInput($request->except('cf-turnstile-response'))
            ->withErrors(['captcha' => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
    }
}
