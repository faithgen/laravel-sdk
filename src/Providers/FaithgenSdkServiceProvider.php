<?php

namespace FaithGen\SDK\Providers;

use Illuminate\Support\ServiceProvider;

class FaithgenSdkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__."/database/migrations");
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
