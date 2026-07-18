<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Auth\AuthServiceInterface;
use App\Interfaces\Thread\ThreadServiceInterface;
use App\Services\Auth\AuthService;
use App\Services\Thread\ThreadService;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
