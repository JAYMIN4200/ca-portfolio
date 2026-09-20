<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_can_view_tasks_index(): void
    {
        Task::factory()->create(['title' => 'Reconcile vendor ledgers']);

        $this->actingAs($this->admin())
            ->get('/admin/tasks')
            ->assertOk()
            ->assertSee('My Tasks')
            ->assertSee('Reconcile vendor ledgers');
    }

    public function test_admin_can_create_a_task(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/admin/tasks', [
                'title' => 'File GSTR-3B',
                'category' => 'GST',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => now()->addDays(3)->toDateString(),
            ])
            ->assertRedirect(route('admin.tasks.index'))
            ->assertSessionHasNoErrors();

        $task = Task::first();

        $this->assertNotNull($task);
        $this->assertSame('File GSTR-3B', $task->title);
        $this->assertSame($admin->id, $task->user_id);
        $this->assertNull($task->completed_at);
    }

    public function test_task_requires_title_priority_and_status(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/tasks', [])
            ->assertSessionHasErrors(['title', 'priority', 'status']);
    }

    public function test_task_priority_and_status_must_be_valid(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/tasks', [
                'title' => 'Invalid task',
                'priority' => 'urgent',
                'status' => 'archived',
            ])
            ->assertSessionHasErrors(['priority', 'status']);
    }

    public function test_tasks_index_filters_by_status_over_ajax(): void
    {
        Task::factory()->pending()->create(['title' => 'Pending task']);
        Task::factory()->done()->create(['title' => 'Finished task']);

        $response = $this->actingAs($this->admin())
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->getJson('/admin/tasks?status=pending');

        $response->assertOk()
            ->assertJsonStructure(['html']);

        $html = $response->json('html');

        $this->assertStringContainsString('Pending task', $html);
        $this->assertStringNotContainsString('Finished task', $html);
    }

    public function test_tasks_index_filters_by_due_date(): void
    {
        $onDate = now()->addDays(2)->toDateString();

        Task::factory()->create(['title' => 'Due on target', 'due_date' => $onDate]);
        Task::factory()->create(['title' => 'Due later', 'due_date' => now()->addDays(9)->toDateString()]);

        $response = $this->actingAs($this->admin())
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->getJson('/admin/tasks?date='.$onDate);

        $html = $response->json('html');

        $this->assertStringContainsString('Due on target', $html);
        $this->assertStringNotContainsString('Due later', $html);
    }

    public function test_admin_can_update_task_status(): void
    {
        $task = Task::factory()->pending()->create();

        $this->actingAs($this->admin())
            ->patch("/admin/tasks/{$task->id}/status", ['status' => 'done'])
            ->assertSessionHasNoErrors();

        $task->refresh();

        $this->assertSame('done', $task->status);
        $this->assertNotNull($task->completed_at);
    }

    public function test_admin_can_toggle_task_active_state(): void
    {
        $task = Task::factory()->create(['is_active' => true]);

        $this->actingAs($this->admin())
            ->patch("/admin/tasks/{$task->id}/toggle")
            ->assertSessionHasNoErrors();

        $this->assertFalse($task->fresh()->is_active);
    }

    public function test_admin_can_delete_a_task(): void
    {
        $task = Task::factory()->create();

        $this->actingAs($this->admin())
            ->delete("/admin/tasks/{$task->id}")
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_calendar_endpoint_returns_month_grid(): void
    {
        $month = now()->format('Y-m');

        Task::factory()->create(['due_date' => now()->startOfMonth()->toDateString()]);

        $this->actingAs($this->admin())
            ->getJson('/admin/tasks/calendar?month='.$month)
            ->assertOk()
            ->assertJsonPath('month', $month)
            ->assertJsonStructure(['html', 'label', 'month']);
    }

    public function test_dashboard_does_not_show_content_overview(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertOk()
            ->assertDontSee('Content Overview');
    }

    public function test_dashboard_meeting_calendar_returns_month_grid(): void
    {
        $month = now()->format('Y-m');

        $this->actingAs($this->admin())
            ->getJson('/admin/calendar?month='.$month)
            ->assertOk()
            ->assertJsonPath('month', $month)
            ->assertJsonStructure(['html', 'label', 'month']);
    }
}
