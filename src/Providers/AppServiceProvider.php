<?php

namespace FaithGen\SDK\Providers;

use FaithGen\SDK\Models\Image;
use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Observers\ImageObserver;
use FaithGen\SDK\Observers\Ministry\ActivationObserver;
use FaithGen\SDK\Observers\MinistryObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Ministry::observe(MinistryObserver::class);
        Image::observe(ImageObserver::class);
        Ministry\Activation::observe(ActivationObserver::class);
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
