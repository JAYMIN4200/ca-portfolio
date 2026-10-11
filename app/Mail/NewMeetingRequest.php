<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMeetingRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Meeting $meeting) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Meeting Request: '.$this->meeting->title,
            replyTo: $this->meeting->email,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new-meeting',
            text: 'emails.admin.new-meeting-text',
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
