<?php

namespace FaithGen\SDK\Traits;

use Illuminate\Support\Facades\Route;

trait ConfigTrait
{
    /**
     * The config you want to be applied onto your routes.
     * @return array the rules eg, middleware, prefix, namespace
     */
    abstract public function routeConfiguration(): array;

    /**
     * This configures the routes with the given routes.
     * @param string|array $primaryRoute the primary route(s) files to be loaded whatsoever
     * @param string|array $secondaryRoute the route(s) files to be loaded when in source mode
     */
    protected function registerRoutes($primaryRoute, $secondaryRoute)
    {
        Route::group($this->routeConfiguration(), function () use ($primaryRoute, $secondaryRoute) {
            $this->loadRoutes($primaryRoute);
            if (config('faithgen-sdk.source')) {
                $this->loadRoutes($secondaryRoute);
            }
        });
    }

    private function loadRoutes($routes)
    {
        if ($routes) {
            if (is_string($routes)) {
                $this->loadRoutesFrom($routes);
            } elseif (is_array($routes)) {
                foreach ($routes as $route) {
                    $this->loadRoutesFrom($route);
                }
            }
        }
    }

    /*
     * Sets up the migrations, views and every other files you want to publish
     */
    protected function setUpSourceFiles(\Closure $closure)
    {
        if ($this->app->runningInConsole()) {
            if (config('faithgen-sdk.source')) {
                $closure->call($this);
            }
        }
    }
}
