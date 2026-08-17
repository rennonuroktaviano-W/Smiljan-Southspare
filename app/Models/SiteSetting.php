<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['section', 'value'];
    protected $casts = ['value' => 'array'];

    private static int $cacheTtl = 3600;

    public static function get(string $section, ?string $key = null): mixed
    {
        $data = Cache::remember("site_setting_{$section}", self::$cacheTtl, function () use ($section) {
            return static::where('section', $section)->value('value') ?? config("site.{$section}");
        });

        if ($key === null) {
            return $data;
        }

        return data_get($data, $key, config("site.{$section}.{$key}"));
    }

    public static function set(string $section, array $value): void
    {
        static::updateOrCreate(
            ['section' => $section],
            ['value' => $value]
        );

        Cache::forget("site_setting_{$section}");
    }

    public static function allSections(): array
    {
        return [
            'brand' => ['label' => 'Brand', 'icon' => '◆'],
            'address' => ['label' => 'Alamat', 'icon' => '◉'],
            'hours' => ['label' => 'Jam Buka', 'icon' => '◷'],
            'social' => ['label' => 'Media Sosial', 'icon' => '◎'],
            'hero' => ['label' => 'Hero', 'icon' => '▣'],
            'manifesto' => ['label' => 'Filosofi', 'icon' => '◈'],
            'space' => ['label' => 'Ruang', 'icon' => '▤'],
            'coffee' => ['label' => 'Menu Kopi', 'icon' => '☕'],
            'coffee_philosophy' => ['label' => 'Filosofi Kopi', 'icon' => '◎'],
            'books' => ['label' => 'Perpustakaan', 'icon' => '▧'],
            'community' => ['label' => 'Komunitas', 'icon' => '⬡'],
            'journal' => ['label' => 'Jurnal', 'icon' => '▦'],
            'quote' => ['label' => 'Kutipan', 'icon' => '❝'],
            'visit' => ['label' => 'Kunjungi', 'icon' => '◈'],
            'about' => ['label' => 'Tentang', 'icon' => '●'],
            'contact' => ['label' => 'Kontak', 'icon' => '✦'],
            'footer' => ['label' => 'Footer', 'icon' => '▬'],
            'status' => ['label' => 'Status', 'icon' => '◉'],
            'nav' => ['label' => 'Navigasi', 'icon' => '☰'],
        ];
    }

    public static function flushCache(?string $section = null): void
    {
        if ($section) {
            Cache::forget("site_setting_{$section}");
        } else {
            foreach (array_keys(self::allSections()) as $s) {
                Cache::forget("site_setting_{$s}");
            }
        }
    }
}
