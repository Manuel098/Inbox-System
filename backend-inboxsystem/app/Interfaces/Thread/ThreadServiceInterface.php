<?php

namespace App\Interfaces\Thread;

use App\DTOs\Thread\ThreadFiltersData;
use App\DTOs\Thread\StoreThreadData;
use App\DTOs\Thread\StoreMessageData;
use App\Models\Thread;
use App\Models\Message;

interface ThreadServiceInterface {
    public function paginate( ThreadFiltersData $payload );
    public function show( Thread $thread );
    public function store(StoreThreadData $data);
    public function storeMessage(StoreMessageData $data);
}
