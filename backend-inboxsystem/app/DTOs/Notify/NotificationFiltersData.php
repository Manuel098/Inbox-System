<?php

namespace App\DTOs\Notify;

use App\Http\Requests\Notify\IndexNotificationRequest;

class NotificationFiltersData
{
    public readonly int $userId;
    public readonly int $perPage;

    public function __construct( int $userId, int $perPage = 20 ) {
        $this->userId    = $userId;
        $this->perPage   = $perPage;
    }

    public static function fromRequest(IndexNotificationRequest $request): self
    {
        return new self(
            userId: auth()->id(),
            perPage: (int)$request->input('per_page', 20)
        );
    }
}
