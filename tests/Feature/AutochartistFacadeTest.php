<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Feature;

use Asciisd\Autochartist\Facades\Autochartist;
use Asciisd\Autochartist\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class AutochartistFacadeTest extends TestCase
{
    public function test_facade_can_access_market_snapshot_service(): void
    {
        Http::fake([
            '*/mr/api/reports/types*' => Http::response(['report_types' => []]),
        ]);

        $result = Autochartist::marketSnapshot()->getSnapshotTypes(
            new \Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotTypesRequest()
        );

        $this->assertIsArray($result);
        $this->assertArrayHasKey('report_types', $result);
    }

    public function test_facade_can_access_technical_analysis_service(): void
    {
        Http::fake([
            '*/to/resources/results*' => Http::response(['results' => []]),
        ]);

        $result = Autochartist::technicalAnalysis()->getTradeSetups();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('results', $result);
    }

    public function test_facade_can_access_news_sentiment_service(): void
    {
        Http::fake([
            '*' => Http::response(['sentiments' => []]),
        ]);

        $result = Autochartist::newsSentiment()->getSentiment();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('sentiments', $result);
    }
}
