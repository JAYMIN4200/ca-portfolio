<?php

namespace Tests\Feature;

use App\Mail\ContactThankYou;
use App\Mail\NewInquiryNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InquiryEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, string>
     */
    private function validPayload(): array
    {
        return [
            'name' => 'Jinendra',
            'email' => 'client@example.com',
            'phone' => '+91 98765 43210',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ];
    }

    public function test_client_receives_a_thank_you_email(): void
    {
        Mail::fake();

        $this->post('/contact', $this->validPayload())->assertSessionHasNoErrors();

        Mail::assertSent(ContactThankYou::class, function (ContactThankYou $mail) {
            return $mail->hasTo('client@example.com')
                && $mail->contactMessage->subject === 'GST Compliance';
        });
    }

    public function test_admin_receives_a_new_inquiry_notification(): void
    {
        Mail::fake();

        User::factory()->create(['is_admin' => true, 'email' => 'admin@example.com']);

        $this->post('/contact', $this->validPayload())->assertSessionHasNoErrors();

        Mail::assertSent(NewInquiryNotification::class, function (NewInquiryNotification $mail) {
            return $mail->hasTo('admin@example.com');
        });
    }
}
