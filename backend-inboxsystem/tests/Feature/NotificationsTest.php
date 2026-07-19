<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
// Models
use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;
use App\Models\Thread;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_notifications(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $thread->users()->attach($user, [ 'last_read_at' => now() ]);
        
        $response = $this->actingAs($user)->getJson('/api/notifications');
        $response->assertOk()->assertJsonStructure([ 'data', 'links', 'meta' ]); 
    }
    
    public function test_sender_does_not_receive_notification_but_other_participants_do(): void
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();
        $thread = Thread::factory()->create();

        $thread->users()->attach([
            $sender->id     => ['last_read_at' => now()],
            $receiver->id   => ['last_read_at' => now()],
        ]);

        $this->actingAs($sender)->postJson("/api/threads/{$thread->id}/messages", [ 'message' => 'Hola', ])->assertCreated();

        // El remitente NO debe tener notificaciones
        $this->assertDatabaseMissing('notifications', [ 'notifiable_id' => $sender->id ]);
        // El otro participante SÍ debe tener una
        $this->assertDatabaseHas('notifications', [ 'notifiable_id' => $receiver->id ]);
    }

    public function test_guest_cannot_list_notifications(): void
    {
        $this->getJson('/api/notifications')->assertUnauthorized();
    }
    
    public function test_user_with_no_notifications_gets_empty_collection(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/notifications');
        $response->assertOk()->assertJsonCount(0, 'data');
    }

    public function test_user_only_sees_his_own_notifications(): void
    {
        $sender     = User::factory()->create();
        $receiver   = User::factory()->create();
        $thread     = Thread::factory()->create();

        $thread->users()->attach([
            $sender->id     => ['last_read_at' => now()],
            $receiver->id   => ['last_read_at' => now()],
        ]);

        $this->actingAs($sender)->postJson("/api/threads/{$thread->id}/messages", [ 'message' => 'Hola' ]);

        // El remitente NO debe tener notificaciones
        $senderResponse =$this->actingAs($sender)->getJson('/api/notifications');
        $senderResponse->assertOk()->assertJsonCount(0, 'data');
        // El otro participante SÍ debe tener una
        $reseiverResponse = $this->actingAs($receiver)->getJson('/api/notifications');
        $reseiverResponse->assertOk()->assertJsonCount(1, 'data');
    }
}
