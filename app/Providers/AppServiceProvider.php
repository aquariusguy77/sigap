<?php

namespace App\Providers;

use App\Services\FirebaseRealtimeDatabaseService;
use App\Services\FirebaseService;
use App\Services\FirebaseStorageService;
use App\Services\RoleAccessService;
use App\Services\SigapDataService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FirebaseService::class);
        $this->app->singleton(FirebaseRealtimeDatabaseService::class);
        $this->app->singleton(FirebaseStorageService::class);
        $this->app->singleton(RoleAccessService::class);
        $this->app->singleton(SigapDataService::class);
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
