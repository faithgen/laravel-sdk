<?php

namespace FaithDen\SDK\Tests;

use FaithDen\SDK\Tests\Models\Ministry;
use FaithGen\SDK\FaithGenSDKServiceProvider;
use FaithGen\SDK\Providers\AuthServiceProvider;
use FaithGen\SDK\Providers\EventServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Providers\LaravelServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->withFactories(__DIR__.'/../database/factories');

    }

    protected function getPackageProviders($app)
    {
        return [
            FaithGenSDKServiceProvider::class,
            AuthServiceProvider::class,
            EventServiceProvider::class,
            LaravelServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('faithgen-sdk.source', true);

        $app['config']->set('auth', [
            'defaults'  => [
                'guard'     => 'web',
                'passwords' => 'users',
            ],
            'guards'    => [
                'api' => [
                    'driver'   => 'jwt',
                    'provider' => 'ministries',
                    'hash'     => false,
                ],
                'web' => [
                    'driver'   => 'session',
                    'provider' => 'ministries',
                ],
            ],
            'passwords' => [
                'users'      => [
                    'provider' => 'users',
                    'table'    => 'password_resets',
                    'expire'   => 60,
                ],
                'ministries' => [
                    'provider' => 'ministries',
                    'table'    => 'password_resets',
                    'expire'   => 60,
                ],
            ],
            'providers' => [
                'ministries' => [
                    'driver' => 'eloquent',
                    'model'  => Ministry::class,
                ],
            ]
        ]);
    }
}
