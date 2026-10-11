<?php

namespace App\Listeners;

use App\Events\ContactMessageSubmitted;
use App\Mail\ContactThankYou;
use Illuminate\Support\Facades\Mail;

class SendContactThankYou
{
    public function handle(ContactMessageSubmitted $event): void
    {
        if (blank($event->message->email)) {
            return;
        }

        Mail::to($event->message->email)->send(new ContactThankYou($event->message));
    }
}
