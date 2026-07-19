<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ThreadController;
use App\Http\Controllers\Api\NotificationController;

Route::post('/sign-in', [AuthController::class, 'signIn']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'getCurrentUser']);
    Route::get('/threads', [ThreadController::class, 'index']);
    Route::post('/threads', [ThreadController::class, 'store']);
    Route::post('/threads/{thread}/messages', [ThreadController::class, 'storeMessage']);
    Route::get('/threads/{thread}', [ThreadController::class, 'show']);
    Route::get('/notifications', [NotificationController::class, 'list']);
});
