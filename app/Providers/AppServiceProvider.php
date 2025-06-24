<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for all URL generation in production
        if (env('APP_ENV') === 'production' || env('APP_ENV') === 'staging') { // Adjust condition as needed
            URL::forceScheme('https');
        }
    }
}
