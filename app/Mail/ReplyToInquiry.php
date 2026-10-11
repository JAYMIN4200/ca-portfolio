<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Models\MessageReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyToInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $contactMessage,
        public MessageReply $reply,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: '.($this->contactMessage->subject ?: 'Your Inquiry'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact.reply',
            text: 'emails.contact.reply-text',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
