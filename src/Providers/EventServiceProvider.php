<?php

namespace FaithGen\SDK\Providers;

use FaithGen\SDK\Models\Image;
use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Models\User;
use FaithGen\SDK\Observers\ImageObserver;
use FaithGen\SDK\Observers\Ministry\ActivationObserver;
use FaithGen\SDK\Observers\MinistryObserver;
use FaithGen\SDK\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class EventServiceProvider extends ServiceProvider
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

        Schema::defaultStringLength(191);

        Ministry::observe(MinistryObserver::class);
        Image::observe(ImageObserver::class);
        Ministry\Activation::observe(ActivationObserver::class);
        User::observe(UserObserver::class);
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
