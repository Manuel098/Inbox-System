<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Thread;
use App\Models\User;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_his_thread(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        $thread->users()->attach($user, [ 'last_read_at' => now() ]);

        $response = $this
            ->actingAs($user)
            ->getJson("/api/threads/{$thread->id}");

        $response
            ->assertOk()
            ->assertJsonStructure([ 'data'=>[ 'id', 'subject', 'messages' ]]);
    }
    
    public function test_user_can_not_view_his_thread(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        $response = $this
            ->actingAs($user)
            ->getJson("/api/threads/{$thread->id}");

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthorized.',
            ]);
    }
    public function test_user_can_not_view_unexistent_thread(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->getJson("/api/threads/1");

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Not found.',
            ]);
    }

    public function test_user_can_create_a_thread(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/threads', [
            'subject' => 'Problema con mi pedido',
            'message' => 'Mi pedido nunca llegó.',
        ]);

        $response->assertStatus(201)->assertJsonStructure([ 'data' => ['id', 'subject', 'status'] ]);
        $this->assertDatabaseHas('threads', [ 'created_by' => $user->id, 'subject' => 'Problema con mi pedido' ]);
        $this->assertDatabaseHas('messages', [ 'user_id' => $user->id, 'body' => 'Mi pedido nunca llegó.' ]);
    }

    public function test_guest_can_not_create_a_thread(): void
    {
        $response = $this->postJson('/api/threads', [ 'subject' => 'Problema', 'message' => 'Mensaje' ]);

        $response->assertUnauthorized()->assertJson([ 'message' => 'Unauthenticated.' ]);
    }

    public function test_subject_is_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/threads', [
            'message' => 'Mi pedido nunca llegó.'
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors([ 'subject' ]);
    }

    public function test_message_is_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson('/api/threads', [
            'subject' => 'Problema'
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors([ 'message' ]);
    }

    public function test_user_can_reply_to_his_thread(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $thread->users()->attach($user, [ 'last_read_at' => now() ]);

        $response = $this->actingAs($user)->postJson("/api/threads/{$thread->id}/messages", [
            'message' => 'Esta es una respuesta.',
        ]);

        $response->assertStatus(201)->assertJsonStructure([ 'data' => [ 'id', 'body', 'thread_id' ] ]);
        $this->assertDatabaseHas('messages', [
            'thread_id' => $thread->id,
            'user_id' => $user->id,
            'body' => 'Esta es una respuesta.',
        ]);
    }

    public function test_user_can_not_reply_to_other_user_thread(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $thread->users()->attach($owner, [ 'last_read_at' => now() ]);

        $response = $this->actingAs($user)->postJson("/api/threads/{$thread->id}/messages", [
            'message' => 'Intento responder.'
        ]);

        $response->assertStatus(401)->assertJson([ 'message' => 'Unauthorized.' ]);
    }

    public function test_guest_can_not_reply_to_a_thread(): void
    {
        $thread = Thread::factory()->create();
        $response = $this->postJson("/api/threads/{$thread->id}/messages", [
            'message' => 'Hola',
        ]);

        $response->assertStatus(401)->assertJson([ 'message' => 'Unauthenticated.' ]);
    }
    public function test_user_can_not_reply_to_non_existing_thread(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/threads/999999/messages', [
            'message' => 'Hola'
        ]);

        $response->assertNotFound();
    }
}
