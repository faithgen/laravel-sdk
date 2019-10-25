<?php

namespace FaithGen\SDK;

use FaithGen\SDK\Http\Middleware\ActivatedMinistryMiddleware;
use FaithGen\SDK\Http\Middleware\SourceSiteMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FaithGenSDKServiceProvider extends ServiceProvider
{

    private $namespace = "FaithGen\SDK\Http\Controllers";

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/config/faithgen-sdk.php', 'faithgen-sdk');

        $this->registerAuthRoutes();
        $this->registerApiRoutes();
        $this->registerParentRoutes();
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');


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

        app('router')->aliasMiddleware('ministry.activated', ActivatedMinistryMiddleware::class);
        app('router')->aliasMiddleware('source.site', SourceSiteMiddleware::class);
    }

    private function apiRouteConfiguration()
    {
        return [
            'prefix' => config('faithgen-sermons.prefix'),
            'namespace' => $this->namespace,
            'middleware' => [
                'auth:api',
                'ministry.activated'
            ]
        ];
    }

    private function registerApiRoutes()
    {
        Route::group($this->apiRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }


    private function parentRouteConfiguration()
    {
        return [
            'prefix' => config('faithgen-sermons.prefix'),
            'namespace' => $this->namespace,
            'middleware' => [
                'auth:api',
                'ministry.activated',
                'source.site'
            ]
        ];
    }

    private function registerParentRoutes()
    {
        Route::group($this->parentRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/source.php');
        });
    }


    private function authRouteConfiguration()
    {
        return [
            'prefix' => config('faithgen-sermons.prefix'),
            'namespace' => $this->namespace,
        ];
    }

    private function registerAuthRoutes()
    {
        Route::group($this->authRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/auth.php');
        });
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
