<?php

namespace App\Listeners;

use App\Events\MeetingScheduled;
use App\Mail\MeetingUpdateToClient;
use Illuminate\Support\Facades\Mail;

class SendMeetingUpdateToClient
{
    public function handle(MeetingScheduled $event): void
    {
        if (blank($event->meeting->email)) {
            return;
        }

        Mail::to($event->meeting->email)->send(new MeetingUpdateToClient($event->meeting));
    }
}
