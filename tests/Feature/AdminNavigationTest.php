<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNavigationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_sidebar_module_search_is_rendered(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.services.index'))
            ->assertOk()
            ->assertSee('id="sidebarSearch"', false)
            ->assertSee('id="sidebarSearchResults"', false);
    }

    public function test_module_pages_render_the_section_switch(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.services.index'))
            ->assertOk()
            ->assertSee('section-switch mb-5', false)
            ->assertSee(route('admin.experiences.index', absolute: false))
            ->assertSee(route('admin.assignments.index', absolute: false));
    }

    public function test_single_item_groups_have_no_section_switch(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.settings.index'))
            ->assertOk()
            ->assertDontSee('section-switch mb-5', false);
    }

    public function test_sidebar_is_flat_with_a_hidden_module_index(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.services.index'))
            ->assertOk()
            ->assertDontSee('data-sidebar-group-toggle', false)
            ->assertSee('id="sidebarModuleExtra"', false)
            ->assertSee('data-sidebar-group-label="Portfolio"', false)
            ->assertSee(route('admin.experiences.index', absolute: false))
            ->assertSee(route('admin.case-studies.index', absolute: false));
    }

    public function test_combined_others_group_gives_tasks_a_section_switch(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.tasks.index'))
            ->assertOk()
            ->assertSee('section-switch mb-5', false)
            ->assertSee(route('admin.blog-posts.index', absolute: false))
            ->assertSee(route('admin.messages.index', absolute: false));
    }

    public function test_last_login_from_session_is_shown_in_the_app_timezone(): void
    {
        $admin = $this->admin();
        $sessionLoginAt = '2026-11-26T15:38:18.000000Z';

        $this->withSession(['previous_login_at' => $sessionLoginAt])
            ->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertSee('26 Nov 2026, 09:08 PM');
    }

    public function test_last_login_falls_back_to_the_user_timestamp_in_the_app_timezone(): void
    {
        $admin = $this->admin();
        $admin->update(['last_login_at' => '2026-11-26 21:25:53']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertSee('26 Nov 2026, 09:25 PM');
    }
}
