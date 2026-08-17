<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
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

    public function test_login_page_returns_200(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_unauthenticated_admin_redirects_to_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_successful_login_redirects_to_dashboard(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->user);
    }

    public function test_failed_login_returns_errors(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_terminal_password_reset_can_be_used_to_login(): void
    {
        $newPassword = 'BaruAman-2026';

        $this->artisan('admin:reset-password', [
            '--email' => ' ADMIN@TEST.COM ',
            '--password' => $newPassword,
        ])->assertSuccessful();

        $this->assertTrue(Hash::check($newPassword, $this->user->fresh()->password));

        $this->post('/admin/login', [
            'email' => ' ADMIN@TEST.COM ',
            'password' => $newPassword,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->user);
    }

    public function test_database_seeder_does_not_overwrite_a_reset_password(): void
    {
        config([
            'admin.email' => $this->user->email,
            'admin.password' => 'InitialPassword123',
        ]);

        $this->user->update(['password' => 'ResetPassword-2026']);

        $this->seed();

        $this->assertTrue(Hash::check('ResetPassword-2026', $this->user->fresh()->password));
    }

    public function test_logout_invalidates_session(): void
    {
        $this->actingAs($this->user);

        $response = $this->post('/admin/logout');
        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_guest_cannot_access_admin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->user)->get('/admin');
        $response->assertStatus(200);
    }
}
