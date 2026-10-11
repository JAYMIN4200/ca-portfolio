<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
            'email' => 'admin@example.com',
        ]);
    }

    public function test_forgot_password_sends_a_reset_link_to_an_existing_admin(): void
    {
        Notification::fake();

        $user = $this->admin();

        $this->post('/admin/forgot-password', ['email' => 'admin@example.com'])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('toast');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_forgot_password_rejects_an_unknown_email(): void
    {
        Notification::fake();

        $this->post('/admin/forgot-password', ['email' => 'nobody@example.com'])
            ->assertSessionHasErrors('email');

        Notification::assertNothingSent();
    }

    public function test_reset_password_page_renders_with_the_token(): void
    {
        $this->get('/admin/reset-password/some-token?email=admin@example.com')
            ->assertOk()
            ->assertSee('some-token')
            ->assertSee('admin@example.com');
    }

    public function test_admin_can_reset_their_password_and_is_redirected_to_login(): void
    {
        $user = $this->admin();
        $token = Password::broker()->createToken($user);

        $this->post('/admin/reset-password', [
            'token' => $token,
            'email' => 'admin@example.com',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertRedirect(route('admin.login'));

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_reset_password_fails_with_an_invalid_token(): void
    {
        $this->admin();

        $this->post('/admin/reset-password', [
            'token' => 'invalid-token',
            'email' => 'admin@example.com',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertSessionHasErrors('email');
    }
}
