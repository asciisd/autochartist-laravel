<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Unit;

use Asciisd\Autochartist\AutochartistManager;
use Asciisd\Autochartist\Services\MarketSnapshotService;
use Asciisd\Autochartist\Services\NewsSentimentService;
use Asciisd\Autochartist\Services\TechnicalAnalysisService;
use Asciisd\Autochartist\Tests\TestCase;

class AutochartistManagerTest extends TestCase
{
    public function test_can_access_market_snapshot_service(): void
    {
        $manager = app(AutochartistManager::class);
        
        $this->assertInstanceOf(MarketSnapshotService::class, $manager->marketSnapshot());
    }

    public function test_can_access_technical_analysis_service(): void
    {
        $manager = app(AutochartistManager::class);
        
        $this->assertInstanceOf(TechnicalAnalysisService::class, $manager->technicalAnalysis());
    }

    public function test_can_access_news_sentiment_service(): void
    {
        $manager = app(AutochartistManager::class);
        
        $this->assertInstanceOf(NewsSentimentService::class, $manager->newsSentiment());
    }

    public function test_services_are_singletons(): void
    {
        $manager = app(AutochartistManager::class);
        
        $service1 = $manager->marketSnapshot();
        $service2 = $manager->marketSnapshot();
        
        $this->assertSame($service1, $service2);
    }
}