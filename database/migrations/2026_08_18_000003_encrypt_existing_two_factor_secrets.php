<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $users = DB::table('users')
            ->whereNotNull('two_factor_secret')
            ->orWhereNotNull('two_factor_recovery_codes')
            ->get();

        foreach ($users as $user) {
            $updates = [];

            foreach (['two_factor_secret', 'two_factor_recovery_codes'] as $field) {
                $raw = $user->{$field};

                if ($raw === null) {
                    continue;
                }

                try {
                    Crypt::decryptString($raw);
                } catch (DecryptException) {
                    $updates[$field] = Crypt::encryptString($raw);
                }
            }

            if ($updates !== []) {
                DB::table('users')->where('id', $user->id)->update($updates);
            }
        }
    }

    public function down(): void
    {
        // Tidak disarankan membalik enkripsi secret (data disimpan terenkripsi demi keamanan).
        // Jika migration ini di-rollback lalu dijalankan ulang, `up()` tetap idempotent.
    }
};
