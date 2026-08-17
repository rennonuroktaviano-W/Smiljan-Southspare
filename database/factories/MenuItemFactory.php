<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category' => fake()->randomElement(['Espresso', 'Filter', 'Milk', 'Non-kopi']),
            'category_note' => null,
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomElement([25000, 28000, 32000, 35000, 40000, 45000]),
            'is_coffee' => true,
            'published' => true,
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }

    public function nonCoffee(): static
    {
        return $this->state(fn () => [
            'is_coffee' => false,
            'category' => fake()->randomElement(['Tea', 'Non-caffeine', 'Snacks']),
        ]);
    }
}
