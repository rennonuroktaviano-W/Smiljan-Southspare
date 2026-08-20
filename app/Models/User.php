<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

#[Fillable(['name', 'email', 'password', 'last_login_at', 'last_login_ip'])]
#[Hidden(['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, LogsActivity, Notifiable;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'two_factor_secret' => 'encrypted',
            'two_factor_recovery_codes' => 'encrypted',
            'last_login_at' => 'datetime',
        ];
    }

    public function getRecoveryCodes(): array
    {
        $decoded = json_decode((string) $this->two_factor_recovery_codes, true);

        return is_array($decoded) ? $decoded : [];
    }

    public function regenerateRecoveryCodes(): array
    {
        $count = max(1, (int) config('admin.two_factor.recovery_codes'));
        $codes = collect(range(1, $count))
            ->map(fn () => strtoupper(Str::random(4).'-'.Str::random(4)))
            ->all();

        $this->two_factor_recovery_codes = json_encode(
            array_map(fn (string $code) => Hash::make($code), $codes)
        );
        $this->save();

        return $codes;
    }

    public function verifyRecoveryCode(string $code): bool
    {
        $codes = $this->getRecoveryCodes();
        $normalized = strtoupper(trim($code));

        foreach ($codes as $index => $hash) {
            if (! Hash::check($normalized, $hash)) {
                continue;
            }

            unset($codes[$index]);
            $this->two_factor_recovery_codes = json_encode(array_values($codes));
            $this->save();

            return true;
        }

        return false;
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
