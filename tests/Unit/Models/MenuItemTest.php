<?php

namespace Tests\Unit;

use App\Models\MenuItem;
use Tests\TestCase;

class MenuItemTest extends TestCase
{
    public function test_published_scope_filters_unpublished(): void
    {
        MenuItem::factory()->create(['published' => true]);
        MenuItem::factory()->create(['published' => false]);

        $this->assertEquals(1, MenuItem::published()->count());
    }

    public function test_price_is_cast_to_integer(): void
    {
        $item = MenuItem::factory()->create(['price' => 28000]);
        $this->assertIsInt($item->price);
    }

    public function test_is_coffee_is_cast_to_boolean(): void
    {
        $item = MenuItem::factory()->create(['is_coffee' => true]);
        $this->assertIsBool($item->is_coffee);
    }
}
