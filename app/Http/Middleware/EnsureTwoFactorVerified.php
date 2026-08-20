<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! session('two_factor_verified')) {
            return $user->two_factor_enabled
                ? redirect()->route('admin.two-factor.challenge')
                : redirect()->route('admin.two-factor.setup');
        }

        return $next($request);
    }
}
