<?php

namespace FaithDen\SDK\Tests;

use FaithDen\SDK\Tests\Models\Ministry;
use FaithGen\SDK\FaithGenSDKServiceProvider;
use FaithGen\SDK\Providers\AuthServiceProvider;
use FaithGen\SDK\Providers\EventServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;

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
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('faithgen-sdk.source', true);
        $app['config']->set('auth.providers', [
            'ministries' => [
                'driver' => 'eloquent',
                'model'  => Ministry::class,
            ],
        ]);

        $app['config']->set('auth.guards', [
            'api' => [
                'driver'   => 'jwt',
                'provider' => 'ministries',
                'hash'     => false,
            ],
        ]);
    }
}
