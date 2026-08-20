<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Tests\TestCase;

class TwoFactorRequiredTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'two_factor_enabled' => true,
            'two_factor_secret' => 'HIHRW3NH67PH6IT5',
        ]);
    }

    public function test_2fa_disable_is_blocked_when_required(): void
    {
        config(['admin.two_factor.required' => true]);

        $response = $this->actingAsAdmin($this->user)
            ->delete(route('admin.two-factor.disable'), [
                'password' => 'password123',
            ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue($this->user->fresh()->two_factor_enabled);
    }

    public function test_2fa_disable_allowed_when_not_required(): void
    {
        config(['admin.two_factor.required' => false]);

        $response = $this->actingAsAdmin($this->user)
            ->delete(route('admin.two-factor.disable'), [
                'password' => 'password123',
            ]);

        $response->assertRedirect();
        $this->assertFalse($this->user->fresh()->two_factor_enabled);
    }

    public function test_2fa_disable_requires_password_confirmation(): void
    {
        config(['admin.two_factor.required' => false]);

        $response = $this->actingAsAdmin($this->user)
            ->delete(route('admin.two-factor.disable'), [
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue($this->user->fresh()->two_factor_enabled);
    }
}
