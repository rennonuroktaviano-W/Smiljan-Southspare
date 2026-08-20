<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const OLD_URL = 'https://maps.google.com/?q=Jl.+BDN+1,+Cilandak+Barat,+Jakarta+Selatan';

    private const PLACE_ID_URL = 'https://www.google.com/maps/place/?q=place_id:0x2e69f100033e3b7d:0xd7296777ad54c268';

    private const NEW_URL = 'https://www.google.com/maps/place/Smiljan+Southspare/@-6.279791,106.7989644,17z/data=!3m1!4b1!4m6!3m5!1s0x2e69f100033e3b7d:0xd7296777ad54c268!8m2!3d-6.279791!4d106.7963895';

    public function up(): void
    {
        $this->swap([self::OLD_URL, self::PLACE_ID_URL], self::NEW_URL);
    }

    public function down(): void
    {
        $this->swap([self::NEW_URL], self::OLD_URL);
    }

    private function swap(array $from, string $to): void
    {
        foreach (['address', 'social', 'contact', 'footer'] as $section) {
            $setting = SiteSetting::where('section', $section)->first();

            if (! $setting) {
                continue;
            }

            $value = $setting->value;
            $changed = false;

            array_walk_recursive($value, function (&$item) use ($from, $to, &$changed) {
                if (in_array($item, $from, true)) {
                    $item = $to;
                    $changed = true;
                }
            });

            if ($changed) {
                SiteSetting::set($section, $value);
            }
        }
    }
};