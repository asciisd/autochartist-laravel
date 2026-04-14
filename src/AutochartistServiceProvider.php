<?php

namespace Mohanad\Autochartist;

use Illuminate\Support\ServiceProvider;
use Mohanad\Autochartist\Contracts\AutochartistClientInterface;
use Mohanad\Autochartist\Http\AutochartistHttpClient;
use Mohanad\Autochartist\Services\MarketSnapshotService;
use Mohanad\Autochartist\Services\NewsSentimentService;
use Mohanad\Autochartist\Services\TechnicalAnalysisService;

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
