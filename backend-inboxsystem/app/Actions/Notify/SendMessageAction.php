<?php

namespace App\Actions\Notify;

use App\Interfaces\Notify\NotificationServiceInterface;
use App\DTOs\Notify\NewNotificationMessageData;

class SendMessageAction
{
    private NotificationServiceInterface $service;
    public function __construct( NotificationServiceInterface $service ) {
        $this->service = $service;
    }

    public function __invoke( NewNotificationMessageData $payload )
    {
        return $this->service->NewNotification($payload);
    }

}
