<?php

namespace FaithDen\SDK\Tests;

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
}
