<?php

namespace App\Providers;

use App\Services\UserCredentialService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;


class UserCredentialProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        /*
        $this->app->bind(UserCredentialService::class, function (Application $app) {
            return new UserCredentialService();
        });
        */
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
