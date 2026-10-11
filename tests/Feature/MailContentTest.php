<?php

namespace Tests\Feature;

use App\Mail\ContactThankYou;
use App\Mail\MeetingUpdateToClient;
use App\Mail\ReplyToInquiry;
use App\Models\ContactMessage;
use App\Models\Meeting;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MailContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_thank_you_email_shows_the_client_details(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jinendra',
            'email' => 'client@example.com',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ]);

        $mailable = new ContactThankYou($message);

        $mailable->assertSeeInHtml('Jinendra');
        $mailable->assertSeeInHtml('GST Compliance');
        $mailable->assertSeeInText('This is a valid test message body.');
    }

    public function test_meeting_update_email_shows_schedule_details(): void
    {
        $meeting = Meeting::factory()->create([
            'status' => 'confirmed',
            'email' => 'riya@example.com',
            'title' => 'Tax consultation',
            'meeting_date' => '2026-11-20',
            'start_time' => '11:00',
            'location' => 'https://meet.google.com/abc-defg-hij',
        ]);

        $mailable = new MeetingUpdateToClient($meeting);

        $mailable->assertSeeInHtml('Your meeting is confirmed');
        $mailable->assertSeeInHtml('Nov 20, 2026');
        $mailable->assertSeeInHtml('meet.google.com');
        $mailable->assertSeeInText('Join link');
    }

    public function test_reset_password_email_renders_the_reset_link(): void
    {
        $html = view('emails.auth.reset-password', [
            'url' => 'http://localhost/admin/reset-password/token-123?email=admin@example.com',
            'userName' => 'Jinendra',
            'expireMinutes' => 60,
        ])->render();

        $this->assertStringContainsString('Reset your password', $html);
        $this->assertStringContainsString('admin/reset-password/token-123', $html);
        $this->assertStringContainsString('Jinendra', $html);
        $this->assertStringContainsString('60 minutes', $html);
    }

    public function test_email_header_falls_back_to_the_text_logo_when_the_favicon_file_is_missing(): void
    {
        SettingsService::set('site_favicon', 'favicon/does-not-exist.png');
        SettingsService::set('logo_text', 'JP');

        $message = ContactMessage::create([
            'name' => 'Jinendra',
            'email' => 'client@example.com',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ]);

        $mailable = new ContactThankYou($message);

        $mailable->assertSeeInHtml('JP');
        $mailable->assertDontSeeInHtml('does-not-exist.png');
    }

    public function test_email_header_embeds_the_favicon_inline_when_the_file_exists(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('favicon/logo.png', 'fake-image-bytes');

        SettingsService::set('site_favicon', 'favicon/logo.png');

        $message = ContactMessage::create([
            'name' => 'Jinendra',
            'email' => 'client@example.com',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ]);

        (new ContactThankYou($message))
            ->assertSeeInHtml('data:image/png;base64,', false);
    }

    public function test_email_header_falls_back_to_the_text_logo_without_a_favicon(): void
    {
        SettingsService::set('site_favicon', null);
        SettingsService::set('logo_text', 'JP');

        $message = ContactMessage::create([
            'name' => 'Jinendra',
            'email' => 'client@example.com',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ]);

        (new ContactThankYou($message))
            ->assertSeeInHtml('JP');
    }

    public function test_reply_email_shows_the_reply_body(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jinendra',
            'email' => 'client@example.com',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ]);
        $reply = $message->replies()->create(['body' => 'Here are the details you asked for.']);

        $mailable = new ReplyToInquiry($message, $reply);

        $mailable->assertSeeInHtml('Here are the details you asked for.');
        $mailable->assertSeeInText('Here are the details you asked for.');
    }
}
