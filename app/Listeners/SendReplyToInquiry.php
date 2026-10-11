<?php

namespace App\Listeners;

use App\Events\MessageReplied;
use App\Mail\ReplyToInquiry;
use Illuminate\Support\Facades\Mail;

class SendReplyToInquiry
{
    public function handle(MessageReplied $event): void
    {
        if (blank($event->message->email)) {
            return;
        }

        Mail::to($event->message->email)->send(new ReplyToInquiry($event->message, $event->reply));
    }
}
