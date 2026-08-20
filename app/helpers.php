<?php

use App\Models\SiteSetting;

if (! function_exists('siteSetting')) {
    function siteSetting(string $section, ?string $key = null): mixed
    {
        return SiteSetting::get($section, $key);
    }
}

if (! function_exists('turnstileEnabled')) {
    function turnstileEnabled(): bool
    {
        $config = config('services.turnstile');

        if (! ($config['enabled'] ?? false) || empty($config['site_key'])) {
            return false;
        }

        if (($config['skip_local'] ?? true) && app()->environment('local')) {
            return false;
        }

        return true;
    }
}

if (! function_exists('honeypotField')) {
    function honeypotField(): string
    {
        return (string) config('admin.security.honeypot_field', 'website');
    }
}
