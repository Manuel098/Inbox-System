<?php

namespace App\DTOs\Thread;

use App\Models\User;
use App\Http\Requests\Thread\StoreThreadRequest;

class StoreThreadData
{
    public readonly User $user;
    public readonly string $subject;
    public readonly string $message;
    /**
     * Create a new class instance.
     */
    public function __construct( User $user, string $subject, string $message ) {
        $this->user     = $user;
        $this->subject  = $subject;
        $this->message  = $message;
    }

    public static function fromRequest(StoreThreadRequest $request): self
    {
        return new self(
            user:       auth()->user(),
            subject:    $request->subject,
            message:    $request->message
        );
    }
}
