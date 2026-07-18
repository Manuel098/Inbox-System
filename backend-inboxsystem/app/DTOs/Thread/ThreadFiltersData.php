<?php

namespace App\DTOs\Thread;

use App\Http\Requests\Thread\IndexThreadRequest;

class ThreadFiltersData
{
    public readonly ?string $search;
    public readonly ?string $status;
    public readonly int $perPage;

    /**
     * Create a new class instance.
     */
    public function __construct( ?string $search, ?string $status, int $perPage ) {
        $this->search   = $search;
        $this->status   = $status;
        $this->perPage  = $perPage;
    }

    public static function fromRequest(IndexThreadRequest $request): self
    {
        return new self(
            search: $request->search,
            status: $request->status,
            perPage: $request->integer('per_page',15)
        );
    }

}
