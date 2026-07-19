<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
// Service
use App\Services\Notify\NotificationService;
// DTOs
use App\DTOs\Notify\NotificationFiltersData;
use App\DTOs\Notify\NewNotificationMessageData;
// Models
use App\Models\User;
use App\Models\Thread;
use App\Models\Message;

use App\Notifications\NewMessageNotification;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_returns_only_unread_notifications(): void
    {
        $user = User::factory()->create();

        $user->notify(new NewMessageNotification(
            sender: User::factory()->create(),
            thread: Thread::factory()->create(),
            message: Message::factory()->create()
        ));

        $user->notify(new NewMessageNotification(
            sender: User::factory()->create(),
            thread: Thread::factory()->create(),
            message: Message::factory()->create()
        ));

        $notification = $user->notify(new NewMessageNotification(
            sender: User::factory()->create(),
            thread: Thread::factory()->create(),
            message: Message::factory()->create()
        ));

        $user->notifications()->latest()->first()->markAsRead();

        $service = new NotificationService();

        $result = $service->list(
            new NotificationFiltersData($user->id)
        );

        $this->assertCount(2, $result);
    }

    public function test_list_respects_per_page(): void
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 15; $i++) {
            $user->notify(new NewMessageNotification(
                sender: User::factory()->create(),
                thread: Thread::factory()->create(),
                message: Message::factory()->create()
            ));
        }

        $service = new NotificationService();

        $result = $service->list(
            new NotificationFiltersData($user->id, 5)
        );

        $this->assertCount(5, $result);
    }

    public function test_list_throws_exception_when_user_does_not_exist(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $service = new NotificationService();

        $service->list(
            new NotificationFiltersData(999999)
        );
    }

    public function test_it_sends_notification_to_recipient(): void
    {
        Notification::fake();

        $sender = User::factory()->create();
        $recipient = User::factory()->create();
        $thread = Thread::factory()->create();
        $message = Message::factory()->create();

        $dto = new NewNotificationMessageData(
            recipient: $recipient,
            sender: $sender,
            thread: $thread,
            message: $message
        );

        $service = new NotificationService();

        $service->NewNotification($dto);

        Notification::assertSentTo(
            $recipient,
            NewMessageNotification::class
        );
    }

}