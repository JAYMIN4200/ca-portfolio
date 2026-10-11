<?php

namespace App\Events;

use App\Models\ContactMessage;
use App\Models\MessageReply;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReplied
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public ContactMessage $message,
        public MessageReply $reply,
    ) {}
}
