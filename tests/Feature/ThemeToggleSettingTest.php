<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeToggleSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SettingsService::flushCache();
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_theme_switcher_is_visible_in_both_panels_by_default(): void
    {
        $this->get('/')
            ->assertSee('data-theme-toggle', false);

        $this->actingAs($this->admin())
            ->get(route('admin.settings.index'))
            ->assertSee('data-theme-toggle', false);
    }

    public function test_disabling_the_setting_hides_the_theme_switcher_in_both_panels(): void
    {
        SettingsService::set('theme_toggle_enabled', '0', 'general');

        $this->get('/')
            ->assertDontSee('data-theme-toggle', false);

        $this->actingAs($this->admin())
            ->get(route('admin.settings.index'))
            ->assertDontSee('data-theme-toggle', false);
    }

    public function test_admin_can_persist_the_theme_switcher_setting(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.settings.update'), [
                'general' => ['theme_toggle_enabled' => '0'],
            ])
            ->assertRedirect(route('admin.settings.index'));

        $this->assertDatabaseHas('settings', [
            'key' => 'theme_toggle_enabled',
            'value' => '0',
            'group' => 'general',
        ]);

        $this->get('/')
            ->assertDontSee('data-theme-toggle', false);
    }

    public function test_an_invalid_theme_switcher_value_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.settings.update'), [
                'general' => ['theme_toggle_enabled' => 'yes'],
            ])
            ->assertSessionHasErrors('general.theme_toggle_enabled');

        $this->assertDatabaseMissing('settings', ['key' => 'theme_toggle_enabled']);
    }
}
