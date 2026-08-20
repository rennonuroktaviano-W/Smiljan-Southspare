<?php

namespace Tests\Feature\Admin;

use App\Models\MenuItem;
use App\Models\User;
use Tests\TestCase;

class MenuCrudTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_200(): void
    {
        $response = $this->actingAsAdmin($this->user)->get(route('admin.menu.index'));
        $response->assertStatus(200);
    }

    public function test_store_creates_menu_item(): void
    {
        $response = $this->actingAsAdmin($this->user)->post(route('admin.menu.store'), [
            'category' => 'Espresso',
            'name' => 'Americano',
            'description' => 'Black coffee',
            'price' => 28000,
        ]);

        $response->assertRedirect(route('admin.menu.index'));
        $this->assertDatabaseHas('menu_items', ['name' => 'Americano']);
    }

    public function test_destroy_deletes_menu_item(): void
    {
        $item = MenuItem::factory()->create();

        $response = $this->actingAsAdmin($this->user)->delete(route('admin.menu.destroy', $item));
        $response->assertRedirect(route('admin.menu.index'));
        $this->assertDatabaseMissing('menu_items', ['id' => $item->id]);
    }
}
