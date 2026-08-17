<?php

namespace Tests\Feature\Admin;

use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.events.index'));
        $response->assertStatus(200);
    }

    public function test_store_creates_event(): void
    {
        $response = $this->actingAs($this->user)->post(route('admin.events.store'), [
            'name' => 'Book Club',
            'description' => 'Weekly book discussion',
            'status' => 'Segera',
        ]);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['name' => 'Book Club']);
    }

    public function test_destroy_deletes_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('admin.events.destroy', $event));
        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
