<?php

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\SignInRequest;


class SignInData
{
    public readonly string $email;
    public readonly string $password;

    public function __construct( $email, $password )
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(SignInRequest $request): self
    {
        return new self($request->email, $request->password);
    }
}
