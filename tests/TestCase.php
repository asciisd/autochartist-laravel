<?php

namespace Asciisd\AutochartistLaravel\Tests;

use Asciisd\AutochartistLaravel\Providers\AutochartistServiceProvider;
use Illuminate\Auth\GenericUser;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(new GenericUser(['id' => 1, 'email' => 'trader@example.com']));
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [AutochartistServiceProvider::class];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('autochartist.broker_id', 1629);
        $app['config']->set('autochartist.secret_key', 'test-secret');
    }
}
