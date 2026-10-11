<?php

namespace App\Listeners;

use App\Events\MeetingRequestSubmitted;
use App\Mail\MeetingRequestReceived;
use Illuminate\Support\Facades\Mail;

class SendMeetingRequestReceived
{
    public function handle(MeetingRequestSubmitted $event): void
    {
        if (blank($event->meeting->email)) {
            return;
        }

        Mail::to($event->meeting->email)->send(new MeetingRequestReceived($event->meeting));
    }
}
