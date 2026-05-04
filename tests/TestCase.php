<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Asciisd\Autochartist\AutochartistServiceProvider;

/**
 * Base TestCase
 * 
 * Provides common test functionality for all package tests.
 */
abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get package providers.
     */
    protected function getPackageProviders($app): array
    {
        return [
            AutochartistServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     */
    protected function defineEnvironment($app): void
    {
        // Setup default configuration
        $app['config']->set('autochartist.base_url', 'https://api.autochartist.com');
        $app['config']->set('autochartist.user', 'test_user');
        $app['config']->set('autochartist.broker_id', 'test_broker');
        $app['config']->set('autochartist.account_type', 'demo');
        $app['config']->set('autochartist.expiry', '2099-12-31');
        $app['config']->set('autochartist.secret_key', 'test_secret_key');
        $app['config']->set('autochartist.token', '');
    }

    /**
     * Helper to mock HTTP responses.
     */
    protected function mockHttpResponse(array $data, int $status = 200): void
    {
        \Illuminate\Support\Facades\Http::fake([
            '*' => \Illuminate\Support\Facades\Http::response($data, $status),
        ]);
    }
}