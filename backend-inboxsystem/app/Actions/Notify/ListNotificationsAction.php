<?php

namespace App\Actions\Notify;

use App\Interfaces\Notify\NotificationServiceInterface;
use App\DTOs\Notify\NotificationFiltersData;

class ListNotificationsAction
{
    private NotificationServiceInterface $service;
    public function __construct( NotificationServiceInterface $service ) {
        $this->service = $service;
    }

    public function __invoke( NotificationFiltersData $payload )
    {
        return $this->service->list($payload);
    }

}
