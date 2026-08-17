<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['Segera', 'Berlangsung', 'Selesai']),
            'event_date' => fake()->dateTimeThisYear(),
            'sort_order' => fake()->numberBetween(0, 20),
        ];
    }
}
