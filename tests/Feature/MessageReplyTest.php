<?php

namespace Tests\Feature;

use App\Mail\ReplyToInquiry;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MessageReplyTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function message(): ContactMessage
    {
        return ContactMessage::create([
            'name' => 'Jinendra',
            'email' => 'client@example.com',
            'phone' => '+91 98765 43210',
            'subject' => 'GST Compliance',
            'message' => 'This is a valid test message body.',
        ]);
    }

    public function test_admin_can_reply_and_the_client_is_emailed(): void
    {
        Mail::fake();

        $message = $this->message();

        $this->actingAs($this->admin())
            ->post("/admin/messages/{$message->id}/reply", ['body' => 'Thank you for reaching out.'])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('message_replies', [
            'contact_message_id' => $message->id,
            'body' => 'Thank you for reaching out.',
        ]);

        Mail::assertSent(ReplyToInquiry::class, function (ReplyToInquiry $mail) {
            return $mail->hasTo('client@example.com')
                && $mail->reply->body === 'Thank you for reaching out.';
        });
    }

    public function test_reply_requires_a_body(): void
    {
        $message = $this->message();

        $this->actingAs($this->admin())
            ->post("/admin/messages/{$message->id}/reply", ['body' => ''])
            ->assertSessionHasErrors('body');
    }

    public function test_replies_are_listed_on_the_message_page(): void
    {
        $message = $this->message();
        $message->replies()->create(['body' => 'This is my reply.']);

        $this->actingAs($this->admin())
            ->get("/admin/messages/{$message->id}")
            ->assertOk()
            ->assertSee('This is my reply.')
            ->assertSee('Replies Sent');
    }
}
