<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_pending_tasks_count(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        Task::factory()->count(2)->pending()->create();
        Task::factory()->done()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertViewHas('stats.tasks_pending', 2)
            ->assertSee('Pending Tasks')
            ->assertSee('data-count-to="2"', false);
    }
}
