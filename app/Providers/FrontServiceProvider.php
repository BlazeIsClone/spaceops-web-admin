<?php

namespace App\Providers;

use App\Services\Front\FrontSocialMediaService;
use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FrontSocialMediaService::class, function ($app) {
            return new FrontSocialMediaService();
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
