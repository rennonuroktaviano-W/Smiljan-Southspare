<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'brand' => config('site.brand'),
            'address' => config('site.address'),
            'hours' => config('site.hours'),
            'social' => config('site.social'),
            'nav' => config('site.nav'),
            'hero' => config('site.hero'),
            'manifesto' => config('site.manifesto'),
            'space' => collect(config('site.space'))->except(['categories'])->toArray(),
            'coffee' => [
                'index' => config('site.coffee.index'),
                'label' => config('site.coffee.label'),
                'en' => config('site.coffee.en'),
                'title' => config('site.coffee.title'),
                'copy' => config('site.coffee.copy'),
                'image' => config('site.coffee.image'),
            ],
            'coffee_philosophy' => config('site.coffee_philosophy'),
            'books' => config('site.books'),
            'community' => collect(config('site.community'))->except(['events'])->toArray(),
            'journal' => [
                'index' => config('site.journal.index'),
                'label' => config('site.journal.label'),
                'en' => config('site.journal.en'),
                'title' => config('site.journal.title'),
            ],
            'quote' => config('site.quote'),
            'visit' => config('site.visit'),
            'about' => config('site.about'),
            'contact' => config('site.contact'),
            'footer' => config('site.footer'),
            'status' => config('site.status'),
        ];

        foreach ($sections as $section => $value) {
            SiteSetting::updateOrCreate(
                ['section' => $section],
                ['value' => $value]
            );
        }
    }
}
