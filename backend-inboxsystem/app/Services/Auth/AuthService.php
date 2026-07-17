<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use App\DTOs\Auth\SignInData;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService implements AuthServiceInterface
{
    public function signIn(SignInData $payload): array
    {
        if (! $token = auth('api')->attempt([ 'email'=>$payload->email, 'password'=>$payload->password])) {
            throw new AuthenticationException('Invalid email or password.');
        }

        return [
            'access_token'  => $token,
            'token_type'    => 'Bearer',
            'expires_in'    => auth('api')->factory()->getTTL() * 60
        ];
    }

    public function user(): User
    {   
        return auth('api')->user();
    }

}
