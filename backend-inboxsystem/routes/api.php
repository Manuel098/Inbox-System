<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ThreadController;

Route::post('/sign-in',[AuthController::class,'signIn']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class,'getCurrentUser']);
    Route::get('/threads', [ThreadController::class,'index']);
    Route::get('/threads/{thread}', [ThreadController::class,'show']);
});
