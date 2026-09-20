<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileSocialLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_save_a_telegram_handle(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->put('/admin/profile', [
                'name' => $admin->name,
                'email' => $admin->email,
                'telegram_url' => 'https://t.me/jinendra_panchal',
            ])
            ->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHasNoErrors();

        $this->assertSame('https://t.me/jinendra_panchal', $admin->profile()->first()->telegram_url);
    }

    public function test_telegram_must_be_a_valid_url(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->put('/admin/profile', [
                'name' => $admin->name,
                'email' => $admin->email,
                'telegram_url' => 'not-a-url',
            ])
            ->assertSessionHasErrors('telegram_url');
    }

    public function test_telegram_handle_is_exposed_via_social_handles(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->profile()->create(['telegram_url' => 'https://t.me/jinendra_panchal']);

        $this->assertSame('https://t.me/jinendra_panchal', $admin->profile->socialHandles()['telegram']);
    }

    public function test_telegram_link_is_rendered_on_the_frontend(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $admin->profile()->create(['telegram_url' => 'https://t.me/jinendra_panchal']);

        $this->get('/about')
            ->assertOk()
            ->assertSee('https://t.me/jinendra_panchal', false);
    }
}
