<?php

use App\Models\SiteSetting;

if (! function_exists('siteSetting')) {
    function siteSetting(string $section, ?string $key = null): mixed
    {
        return SiteSetting::get($section, $key);
    }
}
