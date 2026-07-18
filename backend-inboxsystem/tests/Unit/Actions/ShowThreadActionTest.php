<?php

namespace Tests\Unit\Actions;

use Tests\TestCase; 
use App\Models\Thread;
use Mockery;
use App\Services\Thread\ThreadService;
use App\Actions\Thread\ShowThreadAction;
use Illuminate\Foundation\Testing\RefreshDatabase; 

class ShowThreadActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_action_calls_service(): void
    {
        $service = Mockery::mock(ThreadService::class);
        $thread = Thread::factory()->make();

        $service->shouldReceive('show')
            ->once()
            ->andReturn($thread);

        $action = new ShowThreadAction($service);

        $this->assertEquals( $thread, $action($thread) );
    }
}
