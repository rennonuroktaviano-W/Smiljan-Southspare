<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TurnstileTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);
    }

    private function enableTurnstile(): void
    {
        config([
            'services.turnstile.enabled' => true,
            'services.turnstile.site_key' => 'test-site-key',
            'services.turnstile.secret_key' => 'test-secret-key',
            'services.turnstile.skip_local' => false,
        ]);
    }

    public function test_turnstile_is_skipped_when_disabled(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.two-factor.setup'));
    }

    public function test_turnstile_valid_token_passes(): void
    {
        $this->enableTurnstile();

        Http::fake([
            'https://challenges.cloudflare.com/*' => Http::response(['success' => true], 200),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
            'cf-turnstile-response' => 'valid-token',
        ]);

        $response->assertRedirect(route('admin.two-factor.setup'));
        Http::assertSent(fn ($request) => str_contains($request->url(), 'siteverify'));
    }

    public function test_turnstile_rejects_invalid_token(): void
    {
        $this->enableTurnstile();

        Http::fake([
            'https://challenges.cloudflare.com/*' => Http::response(['success' => false], 200),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
            'cf-turnstile-response' => 'invalid-token',
        ]);

        $response->assertSessionHasErrors(['captcha']);
        $this->assertGuest();
    }

    public function test_turnstile_rejects_missing_token(): void
    {
        $this->enableTurnstile();

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['captcha']);
        $this->assertGuest();
    }

    public function test_turnstile_rejects_unreachable_verifier(): void
    {
        $this->enableTurnstile();

        Http::fake([
            'https://challenges.cloudflare.com/*' => Http::response('server error', 503),
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
            'cf-turnstile-response' => 'token',
        ]);

        $response->assertSessionHasErrors(['captcha']);
        $this->assertGuest();
    }

    public function test_turnstile_protects_contact_form(): void
    {
        $this->enableTurnstile();

        Http::fake([
            'https://challenges.cloudflare.com/*' => Http::response(['success' => false], 200),
        ]);

        $response = $this->post('/kontak', [
            'name' => 'Orang',
            'email' => 'orang@test.com',
            'message' => 'Halo',
            'cf-turnstile-response' => 'invalid-token',
        ]);

        $response->assertSessionHasErrors(['captcha']);
        $this->assertDatabaseCount('messages', 0);
    }
}
