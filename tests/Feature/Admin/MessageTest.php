<?php

namespace Tests\Feature\Admin;

use App\Models\Message;
use App\Models\User;
use Tests\TestCase;

class MessageTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.messages.index'));
        $response->assertStatus(200);
    }

    public function test_read_marks_message_as_read(): void
    {
        $message = Message::factory()->create(['is_read' => false]);

        $response = $this->actingAs($this->user)->post(route('admin.messages.read', $message));
        $response->assertRedirect();
        $this->assertDatabaseHas('messages', ['id' => $message->id, 'is_read' => true]);
    }

    public function test_destroy_deletes_message(): void
    {
        $message = Message::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('admin.messages.destroy', $message));
        $response->assertRedirect();
        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }

    public function test_search_filters_by_name(): void
    {
        Message::factory()->create(['name' => 'Budi']);
        Message::factory()->create(['name' => 'Ani']);

        $response = $this->actingAs($this->user)->get(route('admin.messages.index', ['q' => 'Budi']));
        $response->assertSee('Budi');
        $response->assertDontSee('Ani');
    }
}
