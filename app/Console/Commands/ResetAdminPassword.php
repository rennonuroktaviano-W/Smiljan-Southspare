<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password
                            {--email= : Email admin yang mau di-reset}
                            {--password= : Password baru (kosongkan agar dibuat otomatis)}';
    protected $description = 'Generate password baru untuk admin, password lama otomatis expired';

    public function handle(): int
    {
        $email = mb_strtolower(trim((string) ($this->option('email') ?: config('admin.email') ?: 'admin@smiljan.southspare')));

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User dengan email '{$email}' tidak ditemukan.");
            return self::FAILURE;
        }

        $newPassword = (string) ($this->option('password') ?: $this->generatePassword());

        if (strlen($newPassword) < 8) {
            $this->error('Password baru minimal 8 karakter.');
            return self::FAILURE;
        }

        $user->forceFill([
            'password' => Hash::make($newPassword),
            'remember_token' => null,
        ])->save();

        DB::table(config('auth.passwords.users.table'))
            ->where('email', $user->email)
            ->delete();

        $freshUser = $user->fresh();

        if (! Hash::check($newPassword, $freshUser->password)) {
            $this->error('Gagal memverifikasi password baru. Silakan coba lagi.');
            return self::FAILURE;
        }

        $this->newLine();
        $this->info("Password berhasil di-reset & terverifikasi!");
        $this->newLine();
        $this->table(['Field', 'Value'], [
            ['Email', $user->email],
            ['Password Baru', $newPassword],
        ]);
        $this->newLine();
        $this->warn('Password lama sudah tidak berlaku. Simpan password baru ini!');

        return self::SUCCESS;
    }

    private function generatePassword(): string
    {
        // Hindari karakter yang mudah tertukar saat disalin dari terminal
        // (0/O, 1/l/I) dan pastikan semua kelompok karakter terwakili.
        $groups = [
            'ABCDEFGHJKLMNPQRSTUVWXYZ',
            'abcdefghijkmnopqrstuvwxyz',
            '23456789',
            '!@#$%*-_',
        ];

        $characters = array_map(
            fn (string $group): string => $group[random_int(0, strlen($group) - 1)],
            $groups,
        );

        $pool = implode('', $groups);

        while (count($characters) < 16) {
            $characters[] = $pool[random_int(0, strlen($pool) - 1)];
        }

        shuffle($characters);

        return implode('', $characters);
    }
}
