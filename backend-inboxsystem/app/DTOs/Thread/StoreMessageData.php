<?php

namespace App\DTOs\Thread;

use App\Models\Thread;
use App\Models\User;
use App\Http\Requests\Thread\StoreMessageRequest;

class StoreMessageData
{
    public readonly Thread  $thread;
    public readonly User    $user;
    public readonly string  $message;
    /**
     * Create a new class instance.
     */
    public function __construct( Thread $thread, User $user, string $message ) {
        $this->thread   =  $thread;
        $this->user     =  $user;
        $this->message  =  $message;
    }

    public static function fromRequest(StoreMessageRequest $request): self
    {
        return new self(
            thread:     $request->thread,
            user:       auth()->user(),
            message:    $request->message
        );
    }
}
