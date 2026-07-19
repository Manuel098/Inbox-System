<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

// Models
use App\Models\Message;
use App\Models\Thread;
use App\Models\User;

class NewMessageNotification extends Notification
{
    private User $sender;
    private Thread $thread;
    private Message $message;
    
    public function __construct( User $sender, Thread $thread, Message $message ) {
        $this->sender   = $sender;
        $this->thread   = $thread;
        $this->message  = $message;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $htmlBody = <<<HTML
<div style="font-family: 'Segoe UI', Arial, sans-serif; font-size: 14px; color: #334155; line-height: 1.5; padding: 4px 0;">
    <span style="font-weight: 600; color: #0f172a;">{$this->sender->name}</span> 
    sent you a message regarding 
    <span style="font-weight: 500; color: #4f46e5;">"{$this->thread->subject}"</span>.
</div>
HTML;

        return [
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
            ],
            'thread_id' => $this->thread->id,
            'message_id' => $this->message->id,
            'title' => 'New Message',
            'body' => $htmlBody,
        ];
    }
}