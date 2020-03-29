<?php

namespace FaithGen\SDK;

use FaithGen\SDK\Http\Middleware\ActivatedMinistryMiddleware;
use FaithGen\SDK\Http\Middleware\SourceSiteMiddleware;
use FaithGen\SDK\Mixins\DatabaseBuilder;
use FaithGen\SDK\Services\ImageService;
use FaithGen\SDK\Services\ProfileService;
use FaithGen\SDK\Traits\ConfigTrait;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FaithGenSDKServiceProvider extends ServiceProvider
{
    use ConfigTrait;

    public function boot()
    {
        $this->registerApiRoutes();
        $this->registerParentRoutes();
        $this->registerUserAuthRoutes();

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/../config/faithgen-sdk.php' => config_path('faithgen-sdk.php'),
            ], 'faithgen-sdk-config');

            $this->setUpSourceFiles(function (){
                $this->publishes([
                    __DIR__ . '/../database/migrations/' => database_path('migrations'),
                ], 'faithgen-sdk-migrations');

                $this->publishes([
                    __DIR__ . '/../storage/profile/' => storage_path('app/public/profile'),
                ], 'faithgen-sdk-storage');
            });

            if (!config('faithgen-sdk.source')) {
                $this->publishes([
                    __DIR__ . '/../storage/users/' => storage_path('app/public/users'),
                ], 'faithgen-sdk-storage');
            }

            $this->publishes([
                __DIR__ . '/../storage/logo/' => public_path('images'),
            ], 'faithgen-logo');
        }

        app('router')->aliasMiddleware('ministry.activated', ActivatedMinistryMiddleware::class);
        app('router')->aliasMiddleware('source.site', SourceSiteMiddleware::class);

        Builder::mixin(new DatabaseBuilder(), true);
    }

    private function apiRouteConfiguration()
    {
        return [
            'prefix' => config('faithgen-sdk.prefix'),
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
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    private function parentRouteConfiguration()
    {
        return [
            'prefix' => config('faithgen-sdk.prefix'),
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
        if (config('faithgen-sdk.source')) {
            Route::group($this->parentRouteConfiguration(), function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/source.php');
            });

            $this->registerAuthRoutes();

            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        }
    }

    private function authRouteConfiguration()
    {
        return [
            'prefix' => config('faithgen-sdk.prefix'),
            'middleware' => ['bindings']
        ];
    }

    private function registerAuthRoutes()
    {
        Route::group($this->authRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/auth.php');
        });
    }

    private function registerUserAuthRoutes()
    {
        Route::group($this->authRouteConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/users-auth.php');
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/faithgen-sdk.php', 'faithgen-sdk');

        $this->app->singleton(ProfileService::class);
        $this->app->singleton(ImageService::class);
    }

    /**
     * @inheritDoc
     */
    function routeConfiguration(): array
    {
        // TODO: Implement routeConfiguration() method.
    }
}
