<?php

namespace App\DTOs\Notify;

// Models
use App\Models\Thread;
use App\Models\Message;
use App\Models\User;

class NewNotificationMessageData
{
    public readonly User    $sender;
    public readonly User    $recipient;
    public readonly Message $message;
    public readonly Thread  $thread;

    public function __construct( User $sender, User $recipient, Thread $thread, Message $message )
    {
        $this->sender       = $sender;
        $this->recipient    = $recipient;
        $this->message      = $message;
        $this->thread       = $thread;
    }
    
    public static function fromCall(User $recipient, Thread $thread, Message $message): self
    {
        return new self(
            sender: auth()->user(),
            recipient: $recipient,
            thread: $thread,
            message: $message
        );
    }

}
