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
}
