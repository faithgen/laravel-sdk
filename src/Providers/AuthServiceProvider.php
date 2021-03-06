<?php

namespace FaithGen\SDK\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (request()->headers->has('x-user-key')) {
            $user_id = request()->headers->get('x-user-key');
            Auth::guard('web')->loginUsingId($user_id);
        }

        if (! config('faithgen-sdk.source')) {
            Auth::viaRequest('api-key', function ($request) {
                $api_key = request()->headers->get('x-api-key');
                $class = config('auth.providers.ministries.model');

                return $class::whereHas('apiKey', function ($apiKey) use ($api_key) {
                    return $apiKey->where('api_key', $api_key);
                })->first();
            });
        }
    }
}
