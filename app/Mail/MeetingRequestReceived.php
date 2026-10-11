<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Meeting $meeting) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We received your meeting request: '.$this->meeting->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting.received',
            text: 'emails.meeting.received-text',
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
