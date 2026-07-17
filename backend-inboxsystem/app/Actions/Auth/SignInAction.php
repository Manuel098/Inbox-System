<?php

namespace App\Actions\Auth;

use App\Interfaces\Auth\AuthServiceInterface;
use App\DTOs\Auth\SignInData;

class SignInAction
{
    private AuthServiceInterface $authService;
    
    public function __construct(AuthServiceInterface $authService) {
        $this->authService = $authService;
    }

    public function execute(SignInData $dto): array
    {
        return $this->authService->signIn($dto);
    }
}
