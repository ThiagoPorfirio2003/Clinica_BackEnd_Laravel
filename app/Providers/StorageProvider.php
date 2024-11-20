<?php

namespace App\Providers;

use App\Services\StorageService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class StorageProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StorageService::class, function (Application $app) {
            return new StorageService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
