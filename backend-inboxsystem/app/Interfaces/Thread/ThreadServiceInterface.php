<?php

namespace App\Interfaces\Thread;

use App\DTOs\Thread\ThreadFiltersData;
use App\Models\Thread;

interface ThreadServiceInterface {
    public function paginate( ThreadFiltersData $payload );
    public function show( Thread $thread );
}
