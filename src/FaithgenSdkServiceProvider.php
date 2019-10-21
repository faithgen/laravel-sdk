<?php

namespace FaithGen\SDK;

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
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/faithgen-sdk.php', 'faithgen-sdk');
        $this->publishes([
            __DIR__ . '/config/faithgen-sdk.php' => config_path('faithgen-sdk.php'),
        ]);
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
