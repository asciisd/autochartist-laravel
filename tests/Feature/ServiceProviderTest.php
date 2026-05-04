<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Feature;

use Asciisd\Autochartist\AutochartistServiceProvider;
use Asciisd\Autochartist\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_service_provider_is_loaded(): void
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertArrayHasKey(AutochartistServiceProvider::class, $providers);
    }

    public function test_config_is_published(): void
    {
        $this->assertNotNull(config('autochartist'));
        $this->assertNotNull(config('autochartist.base_url'));
        $this->assertNotNull(config('autochartist.user'));
        $this->assertNotNull(config('autochartist.broker_id'));
    }

    public function test_autochartist_manager_is_bound_to_container(): void
    {
        $this->assertTrue($this->app->bound('autochartist'));
    }

    public function test_can_resolve_autochartist_from_container(): void
    {
        $autochartist = $this->app->make('autochartist');

        $this->assertInstanceOf(\Asciisd\Autochartist\AutochartistManager::class, $autochartist);
    }
}
