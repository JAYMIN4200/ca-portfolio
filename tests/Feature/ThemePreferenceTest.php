<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemePreferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_store_a_frontend_theme_in_the_session(): void
    {
        $this->post(route('theme.update'), ['scope' => 'frontend', 'theme' => 'light'])
            ->assertOk()
            ->assertJson(['saved' => true]);

        $this->assertSame('light', session('theme_frontend'));
    }

    public function test_frontend_and_admin_themes_are_stored_independently(): void
    {
        $this->post(route('theme.update'), ['scope' => 'frontend', 'theme' => 'light']);
        $this->post(route('theme.update'), ['scope' => 'admin', 'theme' => 'dark']);

        $this->assertSame('light', session('theme_frontend'));
        $this->assertSame('dark', session('theme_admin'));
    }

    public function test_an_invalid_theme_is_rejected(): void
    {
        $this->post(route('theme.update'), ['scope' => 'frontend', 'theme' => 'neon'])
            ->assertSessionHasErrors('theme');

        $this->assertNull(session('theme_frontend'));
    }

    public function test_an_invalid_scope_is_rejected(): void
    {
        $this->post(route('theme.update'), ['scope' => 'anything', 'theme' => 'dark'])
            ->assertSessionHasErrors('scope');
    }

    public function test_every_page_defaults_to_the_dark_theme(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('data-theme-default="dark"', false)
            ->assertSee('data-theme-scope="frontend"', false);

        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('data-theme-default="dark"', false)
            ->assertSee('data-theme-scope="admin"', false);
    }

    public function test_the_saved_session_theme_is_applied_on_first_paint(): void
    {
        $this->withSession(['theme_frontend' => 'light'])
            ->get('/')
            ->assertOk()
            ->assertSee('data-theme-session="light"', false);
    }
}
