<?php

namespace Tests\Unit\Services;

use App\Models\Thread;
use App\Models\User;
use App\Services\Thread\ThreadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Exceptions\AuthorizationException;
use Tests\TestCase;

class ThreadServiceTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_participant_can_view_thread(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        $thread->users()->attach($user->id, [ 'last_read_at' => now() ]);
        $this->actingAs($user);

        $service = app(ThreadService::class);
        $result = $service->show($thread);

        $this->assertEquals($thread->id, $result->id);
    }

    public function test_show_updates_last_read_at(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        $thread->users()->attach($user->id, [ 'last_read_at' => now() ]);
        $this->actingAs($user);

        $service = app(ThreadService::class);
        $service->show($thread);

        $this->assertDatabaseHas('thread_user', [
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);

        $this->assertNotNull( $thread->users()->where('users.id', $user->id)->first()->pivot->last_read_at );
    }

    public function test_non_participant_cannot_view_thread(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $thread = Thread::factory()->create();
        $thread->users()->attach($owner, [ 'last_read_at' => now() ]);

        $this->actingAs($other);

        $service = app(ThreadService::class);
        $this->expectException(AuthorizationException::class);
        $service->show($thread);
    }
}
