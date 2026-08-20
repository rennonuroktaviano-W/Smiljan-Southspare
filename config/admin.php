<?php

return [
    'email' => env('ADMIN_EMAIL', 'admin@smiljan.southspare'),
    'password' => env('ADMIN_PASSWORD', 'smiljan123'),

    'two_factor' => [
        'required' => (bool) env('ADMIN_2FA_REQUIRED', true),
        'window' => env('ADMIN_2FA_WINDOW', 3),
        'recovery_codes' => env('ADMIN_2FA_RECOVERY_CODES', 8),
    ],

    'security' => [
        'login_lockout_attempts' => (int) env('ADMIN_LOGIN_LOCKOUT_ATTEMPTS', 5),
        'login_lockout_minutes' => (int) env('ADMIN_LOGIN_LOCKOUT_MINUTES', 15),
        'honeypot_field' => 'website',
    ],
];
