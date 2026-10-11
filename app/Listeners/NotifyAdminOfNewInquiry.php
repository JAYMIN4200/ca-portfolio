<?php

namespace App\Listeners;

use App\Events\ContactMessageSubmitted;
use App\Mail\NewInquiryNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotifyAdminOfNewInquiry
{
    public function handle(ContactMessageSubmitted $event): void
    {
        $adminEmail = User::adminEmail();

        if (blank($adminEmail)) {
            return;
        }

        Mail::to($adminEmail)->send(new NewInquiryNotification($event->message));
    }
}
