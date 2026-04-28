<?php

namespace Asciisd\Autochartist;

use Illuminate\Support\ServiceProvider;
use Asciisd\Autochartist\Contracts\AutochartistClientInterface;
use Asciisd\Autochartist\Http\AutochartistHttpClient;
use Asciisd\Autochartist\Services\MarketSnapshotService;
use Asciisd\Autochartist\Services\NewsSentimentService;
use Asciisd\Autochartist\Services\TechnicalAnalysisService;

class AutochartistServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/autochartist.php',
            'autochartist'
        );

        // Bind HTTP client
        $this->app->singleton(AutochartistClientInterface::class, AutochartistHttpClient::class);

        // Bind services
        $this->app->singleton(TechnicalAnalysisService::class);
        $this->app->singleton(MarketSnapshotService::class);
        $this->app->singleton(NewsSentimentService::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/autochartist.php' => config_path('autochartist.php'),
        ], 'autochartist-config');
    }
}
