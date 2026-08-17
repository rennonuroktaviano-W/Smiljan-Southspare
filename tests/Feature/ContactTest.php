<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactTest extends TestCase
{
    public function test_contact_page_returns_200(): void
    {
        $response = $this->get('/kontak');
        $response->assertStatus(200);
    }

    public function test_contact_form_submits_successfully(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Hello, this is a test message.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('sent', true);

        $this->assertDatabaseHas('messages', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/kontak', []);
        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_contact_form_validates_email_format(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Test',
            'email' => 'not-an-email',
            'message' => 'Test message',
        ]);
        $response->assertSessionHasErrors(['email']);
    }
}
