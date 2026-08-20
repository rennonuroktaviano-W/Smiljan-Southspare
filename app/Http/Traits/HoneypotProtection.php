<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait HoneypotProtection
{
    protected function honeypotFilled(Request $request): bool
    {
        $field = honeypotField();

        return $field !== '' && filled((string) $request->input($field));
    }
}
