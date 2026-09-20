<?php

namespace Tests\Feature;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeetingManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_visitor_can_request_a_meeting(): void
    {
        $this->post('/meetings', [
            'name' => 'Riya Shah',
            'email' => 'riya@example.com',
            'phone' => '+91 98765 43210',
            'title' => 'Tax filing consultation',
            'meeting_date' => now()->addDays(3)->toDateString(),
            'start_time' => '11:00',
            'type' => 'online',
            'notes' => 'Please review my documents.',
        ])
            ->assertRedirect('/contact')
            ->assertSessionHasNoErrors();

        $meeting = Meeting::first();

        $this->assertNotNull($meeting);
        $this->assertSame('pending', $meeting->status);
        $this->assertSame('Riya Shah', $meeting->name);
    }

    public function test_meeting_request_requires_core_fields(): void
    {
        $this->post('/meetings', [])
            ->assertSessionHasErrors(['name', 'email', 'title', 'meeting_date', 'type']);
    }

    public function test_meeting_date_cannot_be_in_the_past(): void
    {
        $this->post('/meetings', [
            'name' => 'Riya Shah',
            'email' => 'riya@example.com',
            'title' => 'Consultation',
            'meeting_date' => now()->subDay()->toDateString(),
            'type' => 'phone',
        ])
            ->assertSessionHasErrors('meeting_date');
    }

    public function test_admin_can_view_meetings_index(): void
    {
        Meeting::factory()->create(['title' => 'Quarterly review']);

        $this->actingAs($this->admin())
            ->get('/admin/meetings')
            ->assertOk()
            ->assertSee('Meetings');
    }

    public function test_admin_can_update_meeting_status(): void
    {
        $meeting = Meeting::factory()->create(['status' => 'pending']);

        $this->actingAs($this->admin())
            ->patch("/admin/meetings/{$meeting->id}/status", ['status' => 'confirmed'])
            ->assertSessionHasNoErrors();

        $this->assertSame('confirmed', $meeting->fresh()->status);
    }

    public function test_meeting_status_must_be_known(): void
    {
        $meeting = Meeting::factory()->create();

        $this->actingAs($this->admin())
            ->patch("/admin/meetings/{$meeting->id}/status", ['status' => 'archived'])
            ->assertSessionHasErrors('status');
    }
}
