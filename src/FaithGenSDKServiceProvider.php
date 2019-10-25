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
        $this->mergeConfigFrom(__DIR__ . '/config/faithgen-sdk.php', 'faithgen-sdk');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->registerAuthRoutes();
        $this->registerApiRoutes();
        $this->registerParentRoutes();

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

            $this->publishes([
                __DIR__ . '/config/faithgen-sdk.php' => config_path('faithgen-sdk.php'),
            ], 'faithgen-sdk-config');

            if (config('faithgen-sdk.source')) {
                $this->publishes([
                    __DIR__ . '/database/migrations/' => database_path('migrations'),
                ], 'faithgen-sdk-migrations');

                $this->publishes([
                    __DIR__ . '/storage/profile/' => storage_path('app/public/profile'),
                ]);
            }
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
                'ministry.activated',
                'bindings'
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
                'source.site',
                'bindings'
            ]
        ];
    }

    private function registerParentRoutes()
    {
        if (config('faithgen-sdk.source'))
            Route::group($this->parentRouteConfiguration(), function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/source.php');
            });
    }


    private function authRouteConfiguration()
    {
        return [
            'prefix' => config('faithgen-sermons.prefix'),
            'namespace' => $this->namespace,
            'middleware' => ['bindings']
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
