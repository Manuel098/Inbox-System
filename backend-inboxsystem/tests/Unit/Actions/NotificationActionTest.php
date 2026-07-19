<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use Mockery;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
// Actions
use App\Actions\Notify\ListNotificationsAction;
use App\Actions\Notify\SendMessageAction;
// Interfaces
use App\Interfaces\Notify\NotificationServiceInterface;
// DTOs
use App\DTOs\Notify\NotificationFiltersData;
use App\DTOs\Notify\NewNotificationMessageData;

class NotificationActionTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_calls_service_to_list_notifications(): void
    {
        $payload = new NotificationFiltersData(1, 20);
        $expected = Mockery::mock(LengthAwarePaginator::class);
        $service = Mockery::mock(NotificationServiceInterface::class);

        $service
            ->shouldReceive('list')
            ->once()
            ->with($payload)
            ->andReturn($expected);

        $action = new ListNotificationsAction($service);

        $result = $action($payload);
        $this->assertSame($expected, $result);
    }

    public function test_it_calls_service_to_send_notification(): void
    {
        $payload = Mockery::mock(NewNotificationMessageData::class);
        $service = Mockery::mock(NotificationServiceInterface::class);

        $service
            ->shouldReceive('NewNotification')
            ->once()
            ->with($payload);

        $action = new SendMessageAction($service);

        $action($payload);
    }

}
