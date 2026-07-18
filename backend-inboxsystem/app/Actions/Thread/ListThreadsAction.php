<?php

namespace App\Actions\Thread;

use App\Services\Thread\ThreadService;
use App\DTOs\Thread\ThreadFiltersData;

class ListThreadsAction
{
    private ThreadService $service;
    /**
     * Create a new class instance.
     */
    public function __construct( ThreadService $service ) {
        $this->service = $service;
    }

    public function __invoke( ThreadFiltersData $payload )
    {
        return $this->service->paginate($payload);
    }
}
