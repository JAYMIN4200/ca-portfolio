<?php

namespace Tests\Feature;

use App\Mail\MeetingRequestReceived;
use App\Mail\MeetingUpdateToClient;
use App\Mail\NewMeetingRequest;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MeetingEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_meeting_request_acknowledges_client_and_notifies_admin(): void
    {
        Mail::fake();

        User::factory()->create(['is_admin' => true, 'email' => 'admin@example.com']);

        $this->post('/meetings', [
            'name' => 'Riya Shah',
            'email' => 'riya@example.com',
            'phone' => '+91 98765 43210',
            'title' => 'Tax filing consultation',
            'meeting_date' => now()->addDays(3)->toDateString(),
            'start_time' => '11:00',
            'type' => 'online',
            'notes' => 'Please review my documents.',
        ])->assertSessionHasNoErrors();

        Mail::assertSent(MeetingRequestReceived::class, function (MeetingRequestReceived $mail) {
            return $mail->hasTo('riya@example.com');
        });

        Mail::assertSent(NewMeetingRequest::class, function (NewMeetingRequest $mail) {
            return $mail->hasTo('admin@example.com');
        });
    }

    public function test_confirming_a_meeting_emails_the_client(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['is_admin' => true]);
        $meeting = Meeting::factory()->create(['email' => 'riya@example.com', 'status' => 'pending']);

        $this->actingAs($admin)
            ->patch("/admin/meetings/{$meeting->id}/status", ['status' => 'confirmed'])
            ->assertSessionHasNoErrors();

        Mail::assertSent(MeetingUpdateToClient::class, function (MeetingUpdateToClient $mail) {
            return $mail->hasTo('riya@example.com') && $mail->meeting->status === 'confirmed';
        });
    }

    public function test_cancelling_a_meeting_emails_the_client(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['is_admin' => true]);
        $meeting = Meeting::factory()->create(['email' => 'riya@example.com', 'status' => 'confirmed']);

        $this->actingAs($admin)
            ->patch("/admin/meetings/{$meeting->id}/status", ['status' => 'cancelled'])
            ->assertSessionHasNoErrors();

        Mail::assertSent(MeetingUpdateToClient::class, function (MeetingUpdateToClient $mail) {
            return $mail->hasTo('riya@example.com') && $mail->meeting->status === 'cancelled';
        });
    }

    public function test_pending_meeting_does_not_email_the_client(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['is_admin' => true]);
        $meeting = Meeting::factory()->create(['email' => 'riya@example.com', 'status' => 'pending']);

        $this->actingAs($admin)->get("/admin/meetings/{$meeting->id}/edit");

        Mail::assertNotSent(MeetingUpdateToClient::class);
    }
}
