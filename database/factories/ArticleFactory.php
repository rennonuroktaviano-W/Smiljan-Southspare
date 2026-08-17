<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'category' => fake()->randomElement(['Cerita', 'Catatan', 'Pikiran', 'Ulasan']),
            'meta' => fake()->randomElement(['5 menit baca', '3 menit baca', '7 menit baca']),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'date' => fake()->dateTimeThisYear(),
            'image_src' => '/images/hero-cafe.webp',
            'image_alt' => fake()->sentence(3),
            'content' => [['type' => 'p', 'text' => fake()->paragraph(3)]],
            'published' => true,
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['published' => false]);
    }
}
