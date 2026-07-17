<?php

namespace App\Actions\Auth;

use App\Interfaces\Auth\AuthServiceInterface;
use App\Models\User;

class UserAction
{
    private AuthServiceInterface $service;
    
    public function __construct(AuthServiceInterface $service) {
        $this->service = $service;
    }

    public function execute(): User
    {
        return $this->service->user();
    }
}
