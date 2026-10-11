<?php

namespace App\Listeners;

use App\Events\MeetingRequestSubmitted;
use App\Mail\NewMeetingRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotifyAdminOfMeetingRequest
{
    public function handle(MeetingRequestSubmitted $event): void
    {
        $adminEmail = User::adminEmail();

        if (blank($adminEmail)) {
            return;
        }

        Mail::to($adminEmail)->send(new NewMeetingRequest($event->meeting));
    }
}
