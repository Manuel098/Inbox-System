<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class AuthorizationException extends Exception
{
    public function render(Request $request)
    {
        return response()->json(['message' => 'Unauthorized.'], 401);
    }
}
