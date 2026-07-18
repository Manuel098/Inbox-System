<?php

namespace Tests\Unit\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase; 
use Tests\TestCase; 
//Models
use App\Models\Thread;
use App\Models\Message;
use Mockery;
// SERVICES
use App\Services\Thread\ThreadService;
// ACTIONS
use App\Actions\Thread\ShowThreadAction;
use App\Actions\Thread\StoreThreadAction;
use App\Actions\Thread\StoreMessageAction;
// DDTOs
use App\DTOs\Thread\StoreThreadData;
use App\DTOs\Thread\StoreMessageData;

class ShowThreadActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_thread_action_calls_service(): void
    {
        $service = Mockery::mock(ThreadService::class);
        $thread = Thread::factory()->make();

        $service->shouldReceive('show')
            ->once()
            ->andReturn($thread);

        $action = new ShowThreadAction($service);

        $this->assertEquals( $thread, $action($thread) );
    }

    public function test_store_thread_action_calls_service(): void
    {
        $service = Mockery::mock(ThreadService::class);
        $data = Mockery::mock(StoreThreadData::class);
        $thread = Thread::factory()->make();

        $service->shouldReceive('store')->once()->with($data)->andReturn($thread);
        $action = new StoreThreadAction($service);
        
        $result = $action($data);
        $this->assertSame($thread, $result);
    }
    public function test_store_message_action_calls_service(): void
    {
        $service = Mockery::mock(ThreadService::class);
        $data = Mockery::mock(StoreMessageData::class);
        $thread = Thread::factory()->make();
        
        $service->shouldReceive('storeMessage')->once()->with($data)->andReturn($thread);
        $action = new StoreMessageAction($service);

        $result = $action($data);
        $this->assertSame($thread, $result);
    }
}
