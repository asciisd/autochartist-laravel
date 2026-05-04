<?php

declare(strict_types=1);

namespace Asciisd\Autochartist;

use Asciisd\Autochartist\Services\AuthenticationService;
use Asciisd\Autochartist\Services\MarketSnapshotService;
use Asciisd\Autochartist\Services\NewsSentimentService;
use Asciisd\Autochartist\Services\TechnicalAnalysisService;
use Illuminate\Support\ServiceProvider;

/**
 * Autochartist Service Provider
 *
 * Registers all services and publishes configuration.
 */
final class AutochartistServiceProvider extends ServiceProvider
{
    /**
     * Register services in the container.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/autochartist.php',
            'autochartist'
        );

        $this->registerAuthenticationService();
        $this->registerApiServices();
        $this->registerManager();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishConfiguration();
    }

    /**
     * Register authentication service with configuration.
     * 
     * Note: Not using singleton to allow per-request user-specific credentials.
     */
    private function registerAuthenticationService(): void
    {
        $this->app->bind(AuthenticationService::class, function () {
            return new AuthenticationService(
                user: config('autochartist.user'),
                brokerId: config('autochartist.broker_id'),
                accountType: config('autochartist.account_type'),
                expiry: config('autochartist.expiry'),
                secretKey: config('autochartist.secret_key'),
            );
        });
    }

    /**
     * Register API service classes.
     * 
     * Note: Not using singleton to support per-request user-specific authentication.
     */
    private function registerApiServices(): void
    {
        $this->app->bind(MarketSnapshotService::class);
        $this->app->bind(TechnicalAnalysisService::class);
        $this->app->bind(NewsSentimentService::class);
    }

    /**
     * Register the Autochartist manager for facade.
     * 
     * Note: Not using singleton to support per-request user-specific authentication.
     */
    private function registerManager(): void
    {
        $this->app->bind(AutochartistManager::class);
    }

    /**
     * Publish configuration file.
     */
    private function publishConfiguration(): void
    {
        $this->publishes([
            __DIR__ . '/Config/autochartist.php' => config_path('autochartist.php'),
        ], 'autochartist-config');
    }
}