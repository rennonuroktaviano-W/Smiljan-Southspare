<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $nonce = Str::random(32);
        request()->attributes->set('csp_nonce', $nonce);

        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('X-DNS-Prefetch-Control', 'off');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Embedder-Policy', 'credentialless');

        $permissionsPolicy = implode(', ', [
            'camera=()',
            'microphone=()',
            'geolocation=()',
            'payment=()',
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
            'midi=()',
            'xr-spatial-tracking=()',
            'autoplay=(self)',
            'fullscreen=(self)',
        ]);
        $response->headers->set('Permissions-Policy', $permissionsPolicy);

        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=63072000; includeSubDomains; preload');
        }

        $dev = config('app.env') !== 'production';

        $devOrigins = $dev
            ? ' http://localhost:* https://localhost:* http://127.0.0.1:* https://127.0.0.1:* http://[::1]:* https://[::1]:*'
            : '';

        $turnstile = turnstileEnabled() ? 'https://challenges.cloudflare.com' : '';

        $fontSrc = $dev ? "https://fonts.bunny.net{$devOrigins}" : 'https://fonts.bunny.net';
        $connectSrc = $dev ? "'self'{$devOrigins}{$turnstile}" : "'self'{$turnstile}";
        $scriptSrc = $dev ? "'self' 'nonce-{$nonce}'{$devOrigins}{$turnstile}" : "'self' 'nonce-{$nonce}'{$turnstile}";
        $styleSrc = $dev ? "'self' 'unsafe-inline'{$devOrigins}{$turnstile}" : "'self' 'unsafe-inline'{$turnstile}";
        $imgSrc = $dev ? "'self' data: blob: https:{$devOrigins}" : "'self' data: blob: https:";
        $frameSrc = $turnstile !== '' ? "'self'{$turnstile}" : "'self'";

        $csp = "default-src 'self'; "
            ."script-src {$scriptSrc}; "
            ."style-src {$styleSrc}; "
            ."img-src {$imgSrc}; "
            ."font-src 'self' {$fontSrc}; "
            ."connect-src {$connectSrc}; "
            ."frame-src {$frameSrc}; "
            ."frame-ancestors 'self'; "
            ."base-uri 'self'; "
            ."form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        if ($request->is('admin/*') || $request->is('admin')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
        }

        return $response;
    }
}
