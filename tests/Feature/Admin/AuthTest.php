<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class AuthTest extends TestCase
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

    public function test_successful_login_redirects_to_two_factor_setup(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.two-factor.setup'));
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
        ])->assertRedirect(route('admin.two-factor.setup'));

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

    public function test_terminal_password_reset_with_reset_2fa_flag_disables_two_factor(): void
    {
        $this->user->forceFill([
            'two_factor_enabled' => true,
            'two_factor_secret' => 'HIHRW3NH67PH6IT5',
            'two_factor_recovery_codes' => json_encode([bcrypt('ABCD-EFGH')]),
        ])->save();

        $this->artisan('admin:reset-password', [
            '--email' => $this->user->email,
            '--password' => 'BaruAman-2026',
            '--reset-2fa' => true,
        ])->assertSuccessful();

        $fresh = $this->user->fresh();

        $this->assertTrue(Hash::check('BaruAman-2026', $fresh->password));
        $this->assertFalse($fresh->two_factor_enabled);
        $this->assertNull($fresh->two_factor_secret);
        $this->assertNull($fresh->two_factor_recovery_codes);
    }

    public function test_two_factor_secret_is_encrypted_at_rest(): void
    {
        $this->user->forceFill([
            'two_factor_enabled' => true,
            'two_factor_secret' => 'HIHRW3NH67PH6IT5',
        ])->save();

        $raw = DB::table('users')->where('id', $this->user->id)->value('two_factor_secret');

        $this->assertNotSame('HIHRW3NH67PH6IT5', $raw);
        $this->assertSame('HIHRW3NH67PH6IT5', $this->user->fresh()->two_factor_secret);
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
        $response = $this->actingAs($this->user)
            ->withSession(['two_factor_verified' => true])
            ->get('/admin');

        $response->assertStatus(200);
    }

    public function test_dashboard_blocked_until_two_factor_verified(): void
    {
        $this->actingAs($this->user)
            ->get('/admin')
            ->assertRedirect(route('admin.two-factor.setup'));

        $this->user->forceFill(['two_factor_enabled' => true])->save();

        $this->actingAs($this->user)
            ->get('/admin')
            ->assertRedirect(route('admin.two-factor.challenge'));
    }

    public function test_two_factor_setup_flow_completes_login(): void
    {
        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ])->assertRedirect(route('admin.two-factor.setup'));

        $this->get(route('admin.two-factor.setup'));

        $secret = session('two_factor_pending_secret');
        $this->assertNotNull($secret);

        $code = (new Google2FA)->getCurrentOtp($secret);

        $this->post(route('admin.two-factor.enable'), ['code' => $code])
            ->assertRedirect(route('admin.two-factor.recovery'));

        $recoveryCodes = session('recovery_codes');
        $this->assertNotEmpty($recoveryCodes);
        $this->assertTrue($this->user->fresh()->two_factor_enabled);

        $this->get(route('admin.two-factor.recovery'))->assertStatus(200);

        $this->post(route('admin.two-factor.recovery.confirm'))
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->user);
        $this->assertTrue(session('two_factor_verified'));
    }

    public function test_challenge_accepts_valid_totp_code(): void
    {
        $this->enableTwoFactor();

        $this->post('/admin/logout');

        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ])->assertRedirect(route('admin.two-factor.challenge'));

        $this->get(route('admin.two-factor.challenge'))->assertStatus(200);

        $secret = $this->user->fresh()->two_factor_secret;
        $code = (new Google2FA)->getCurrentOtp($secret);

        $this->post(route('admin.two-factor.verify'), ['code' => $code])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->user);
        $this->assertTrue(session('two_factor_verified'));
    }

    public function test_challenge_rejects_wrong_code(): void
    {
        $this->enableTwoFactor();

        $this->post('/admin/logout');

        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $this->post(route('admin.two-factor.verify'), ['code' => '000000'])
            ->assertSessionHasErrors(['code']);

        $this->assertFalse(session()->has('two_factor_verified'));
    }

    public function test_recovery_code_can_complete_login(): void
    {
        $codes = $this->enableTwoFactor();

        $this->post('/admin/logout');

        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ])->assertRedirect(route('admin.two-factor.challenge'));

        $this->post(route('admin.two-factor.verify'), ['code' => $codes[0]])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->user);
        $this->assertTrue(session('two_factor_verified'));
        $this->assertCount(count($codes) - 1, $this->user->fresh()->getRecoveryCodes());
    }

    private function enableTwoFactor(): array
    {
        $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $this->get(route('admin.two-factor.setup'));

        $secret = session('two_factor_pending_secret');
        $code = (new Google2FA)->getCurrentOtp($secret);

        $this->post(route('admin.two-factor.enable'), ['code' => $code]);

        $codes = session('recovery_codes');

        $this->post(route('admin.two-factor.recovery.confirm'));

        return $codes;
    }
}
