<?php

namespace App\Mail;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingUpdateToClient extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Meeting $meeting) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting.update',
            text: 'emails.meeting.update-text',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    private function subjectLine(): string
    {
        return match ($this->meeting->status) {
            'confirmed' => 'Your Meeting is Confirmed: '.$this->meeting->title,
            'cancelled' => 'Your Meeting has been Cancelled: '.$this->meeting->title,
            default => 'Your Meeting has been Updated: '.$this->meeting->title,
        };
    }
}
