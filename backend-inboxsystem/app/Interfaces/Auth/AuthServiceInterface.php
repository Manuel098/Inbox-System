<?php

namespace App\Interfaces\Auth;

use App\Models\User;
use App\DTOs\Auth\SignInData;

interface AuthServiceInterface
{
    public function signIn(SignInData $dto): array;
    public function user(): User;
}