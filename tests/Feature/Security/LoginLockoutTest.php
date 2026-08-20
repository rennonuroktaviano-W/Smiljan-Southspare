<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Tests\TestCase;

class LoginLockoutTest extends TestCase
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

    public function test_repeated_failures_lock_the_account(): void
    {
        config([
            'admin.security.login_lockout_attempts' => 2,
            'admin.security.login_lockout_minutes' => 15,
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-1',
        ])->assertSessionHasErrors(['email']);

        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-2',
        ])->assertSessionHasErrors(['email']);

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
        $response->assertSessionHasErrorsIn('default', 'email');
    }

    public function test_successful_login_clears_lockout_attempts(): void
    {
        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-1',
        ])->assertSessionHasErrors(['email']);

        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ])->assertRedirect(route('admin.two-factor.setup'));

        $this->assertAuthenticatedAs($this->user);
    }
}
