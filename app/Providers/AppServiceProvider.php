<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\BladeDirectives;


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
        // Register the custom Blade directive
        BladeDirectives::register();
    }
}
