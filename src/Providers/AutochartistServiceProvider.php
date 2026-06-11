<?php

namespace Asciisd\AutochartistLaravel\Providers;

use Asciisd\AutochartistLaravel\Services\AutochartistAuthenticator;
use Asciisd\AutochartistLaravel\Services\AutochartistClient;
use Asciisd\AutochartistLaravel\Services\AutochartistManager;
use Illuminate\Support\ServiceProvider;

class AutochartistServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/autochartist.php',
            'autochartist'
        );

        $this->app->singleton(AutochartistAuthenticator::class);
        $this->app->singleton(AutochartistClient::class);
        $this->app->singleton(AutochartistManager::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/autochartist.php' => config_path('autochartist.php'),
            ], 'autochartist-config');
        }
    }
}
