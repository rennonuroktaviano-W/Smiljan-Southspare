<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class HoneypotTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_contact_form_rejects_honeypot_filled(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Bot',
            'email' => 'bot@test.com',
            'message' => 'spam spam spam',
            'website' => 'http://spam.example',
        ]);

        $response->assertSessionHas('sent');
        $this->assertDatabaseCount('messages', 0);
    }

    public function test_contact_form_accepts_clean_submission(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Manusia',
            'email' => 'manusia@test.com',
            'message' => 'Pesan normal',
        ]);

        $response->assertSessionHas('sent');
        $this->assertDatabaseHas('messages', ['email' => 'manusia@test.com']);
    }

    public function test_login_rejects_honeypot_filled(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
            'website' => 'http://spam.example',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_forgot_password_rejects_honeypot_filled(): void
    {
        $response = $this->post('/admin/forgot-password', [
            'email' => 'admin@test.com',
            'website' => 'http://spam.example',
        ]);

        $response->assertSessionHas('ok');
    }
}
