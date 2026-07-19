<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Interfaces
use App\Interfaces\Auth\AuthServiceInterface;
use App\Interfaces\Thread\ThreadServiceInterface;
use App\Interfaces\Notify\NotificationServiceInterface;
// Services
use App\Services\Auth\AuthService;
use App\Services\Thread\ThreadService;
use App\Services\Notify\NotificationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auth Provider
        $this->app->bind( AuthServiceInterface::class, AuthService::class );
        // Thread Provider
        $this->app->bind( ThreadServiceInterface::class, ThreadService::class );
        // Thread Provider
        $this->app->bind( NotificationServiceInterface::class, NotificationService::class );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
