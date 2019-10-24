<?php

namespace FaithGen\SDK;

use FaithGen\SDK\Http\Middleware\ActivatedMinistryMiddleware;
use FaithGen\SDK\Models\Image;
use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Observers\ImageObserver;
use FaithGen\SDK\Observers\Ministry\ActivationObserver;
use FaithGen\SDK\Observers\MinistryObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class FaithgenSdkServiceProvider extends ServiceProvider
{
    protected $listen = [
        \FaithGen\SDK\Events\Ministry\Profile\ImageSaved::class => [
            \FaithGen\SDK\Listeners\Ministry\Profile\ImageSaved\ProcessImage::class,
            \FaithGen\SDK\Listeners\Ministry\Profile\ImageSaved\S3Upload::class,
        ],
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/faithgen-sdk.php', 'faithgen-sdk');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/faithgen-sdk.php' => config_path('faithgen-sdk.php'),
            ], 'faithgen-config');

            $this->publishes([
                __DIR__ . '/database/migrations/' => database_path('migrations'),
            ], 'faithgen-migrations');

            $this->publishes([
                __DIR__ . '/storage/profile/' => storage_path('app/public/profile'),
            ]);
        }

        Schema::defaultStringLength(191);
        Ministry::observe(MinistryObserver::class);
        Image::observe(ImageObserver::class);
        Ministry\Activation::observe(ActivationObserver::class);

        app('router')->aliasMiddleware('ministry.activated', ActivatedMinistryMiddleware::class);
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
