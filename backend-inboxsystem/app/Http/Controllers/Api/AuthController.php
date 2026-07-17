<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Auth\SignInAction;
use App\Actions\Auth\UserAction;
use App\Http\Requests\Auth\SignInRequest;
use App\DTOs\Auth\SignInData;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
     * 
     */
    public function signIn(SignInRequest $request, SignInAction $action)
    {
        return response()->json(
            $action->execute(SignInData::fromRequest($request))
        );
    }

    /**
     * 
     */
    public function getCurrentUser(UserAction $action)
    {
        return new UserResource($action->execute());
    }
}