<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedAdmin();
        $this->seedSiteSettings();
        $this->seedArticles();
        $this->seedMenu();
        $this->seedEvents();
    }

    private function seedAdmin(): void
    {
        User::firstOrCreate(
            ['email' => mb_strtolower(trim((string) (config('admin.email') ?: 'admin@smiljan.southspare')))],
            [
                'name' => 'Admin',
                'password' => config('admin.password') ?: 'smiljan123',
            ]
        );
    }

    private function seedSiteSettings(): void
    {
        $this->call(SiteSettingSeeder::class);
    }

    private function seedArticles(): void
    {
        foreach (config('site.journal.articles') as $index => $article) {
            Article::updateOrCreate(
                ['slug' => $article['slug']],
                [
                    'category' => $article['category'],
                    'meta' => $article['meta'],
                    'title' => $article['title'],
                    'excerpt' => $article['excerpt'],
                    'date' => $article['date'],
                    'image_src' => $article['src'],
                    'image_alt' => $article['alt'],
                    'content' => $article['content'],
                    'published' => true,
                    'sort_order' => $index,
                ]
            );
        }
    }

    private function seedMenu(): void
    {
        $sort = 0;

        foreach (config('site.coffee.categories') as $category) {
            foreach ($category['items'] as $item) {
                MenuItem::updateOrCreate(
                    ['name' => $item['name'], 'category' => $category['name']],
                    [
                        'category_note' => $category['note'],
                        'description' => $item['desc'],
                        'price' => $item['price'],
                        'is_coffee' => true,
                        'published' => true,
                        'sort_order' => $sort++,
                    ]
                );
            }
        }

        foreach ($this->nonCoffee() as $category) {
            foreach ($category['items'] as $item) {
                MenuItem::updateOrCreate(
                    ['name' => $item['name'], 'category' => $category['name']],
                    [
                        'category_note' => $category['note'],
                        'description' => $item['desc'],
                        'price' => $item['price'],
                        'is_coffee' => false,
                        'published' => true,
                        'sort_order' => $sort++,
                    ]
                );
            }
        }
    }

    private function nonCoffee(): array
    {
        return [
            [
                'name' => 'TEH',
                'note' => 'Diseduh dari daun, bukan kantong',
                'items' => [
                    ['name' => 'Teh Melati', 'desc' => 'Harum, ringan, menenangkan.', 'price' => 28000],
                    ['name' => 'Genmaicha', 'desc' => 'Teh hijau dengan nasi panggang.', 'price' => 32000],
                    ['name' => 'Chamomile', 'desc' => 'Untuk malam yang pelan.', 'price' => 30000],
                ],
            ],
            [
                'name' => 'NON-KAFEIN',
                'note' => 'Tanpa kafein, tanpa buru-buru',
                'items' => [
                    ['name' => 'Kakao Panas', 'desc' => 'Cokelat hangat yang lembut.', 'price' => 38000],
                    ['name' => 'Matcha Latte', 'desc' => 'Hijau, halus, dan tenang.', 'price' => 43000],
                    ['name' => 'Air Kelapa', 'desc' => 'Segar dan sederhana.', 'price' => 30000],
                ],
            ],
            [
                'name' => 'MAKANAN RINGAN',
                'note' => 'Teman untuk tinggal lebih lama',
                'items' => [
                    ['name' => 'Butter Croissant', 'desc' => 'Berlapis, renyah, hangat.', 'price' => 25000],
                    ['name' => 'Banana Bread', 'desc' => 'Resep keluarga, dipanggang pagi.', 'price' => 28000],
                    ['name' => 'Tuna Melt Sandwich', 'desc' => 'Sederhana dan mengenyangkan.', 'price' => 45000],
                    ['name' => 'Pudding Roti', 'desc' => 'Lembut, manis secukupnya.', 'price' => 32000],
                ],
            ],
        ];
    }

    private function seedEvents(): void
    {
        foreach (config('site.community.events') as $index => $event) {
            Event::updateOrCreate(
                ['name' => $event['name']],
                [
                    'description' => $event['desc'],
                    'status' => $event['status'],
                    'sort_order' => $index,
                ]
            );
        }
    }
}
