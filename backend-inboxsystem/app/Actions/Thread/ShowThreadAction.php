<?php

namespace App\Actions\Thread;

use App\Models\Thread;
use App\Services\Thread\ThreadService;

class ShowThreadAction
{
    private ThreadService $service;
    /**
     * Create a new class instance.
     */
    public function __construct( ThreadService $service ) {
        $this->service = $service;
    }

    public function __invoke( Thread $thread ) {
        return $this->service->show($thread);
    }

}
