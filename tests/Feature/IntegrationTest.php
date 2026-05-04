<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Feature;

use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotRequest;
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\TradeSetupsRequest;
use Asciisd\Autochartist\Facades\Autochartist;
use Asciisd\Autochartist\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class IntegrationTest extends TestCase
{
    public function test_complete_market_snapshot_workflow(): void
    {
        Http::fake([
            '*/mr/api/reports/types*' => Http::response([
                'report_types' => [
                    ['id' => '1', 'name' => 'Daily Report'],
                ],
            ]),
            '*/mr/api/reports/123/latest*' => Http::response([
                'snapshot' => ['data' => 'test'],
            ]),
            '*/mr/api/reports/*' => Http::response([
                'instances' => [
                    ['report_id' => '123', 'date' => '2026-05-04'],
                ],
            ]),
        ]);

        // Get snapshot types
        $types = Autochartist::marketSnapshot()->getSnapshotTypes(
            new \Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotTypesRequest()
        );
        $this->assertArrayHasKey('report_types', $types);

        // Get snapshot instances
        $instances = Autochartist::marketSnapshot()->getSnapshotInstances(
            new \Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotInstancesRequest()
        );
        $this->assertArrayHasKey('instances', $instances);

        // Get specific snapshot
        $snapshot = Autochartist::marketSnapshot()->getSnapshot(
            new SnapshotRequest(reportId: 123)
        );
        $this->assertArrayHasKey('snapshot', $snapshot);
    }

    public function test_complete_technical_analysis_workflow(): void
    {
        Http::fake([
            '*/to/resources/results/detail/*' => Http::response([
                'pattern' => ['type' => 'Triangle'],
            ]),
            '*/to/resources/results*' => Http::response([
                'results' => [
                    ['id' => '456', 'symbol' => 'EURUSD'],
                ],
            ]),
        ]);

        // Get trade setups
        $setups = Autochartist::technicalAnalysis()->getTradeSetups(
            new TradeSetupsRequest()
        );
        $this->assertArrayHasKey('results', $setups);

        // Get pattern detail
        $detail = Autochartist::technicalAnalysis()->getPatternDetail(
            new \Asciisd\Autochartist\DTOs\TechnicalAnalysis\PatternDetailRequest(type: 'pattern', uid: '456')
        );
        $this->assertArrayHasKey('pattern', $detail);
    }

    public function test_complete_news_sentiment_workflow(): void
    {
        Http::fake([
            '*/newssentiment/sentiment*' => Http::response([
                'sentiments' => [
                    ['ticker' => 'AAPL', 'score' => 75],
                ],
            ]),
            '*/newssentiment/history*' => Http::response([
                'history' => [
                    ['date' => '2026-05-01', 'score' => 70],
                ],
            ]),
            '*/newssentiment/sectors*' => Http::response([
                'sectors' => [
                    ['id' => 1, 'name' => 'Technology'],
                ],
            ]),
        ]);

        // Get sentiment
        $sentiment = Autochartist::newsSentiment()->getSentiment(
            new \Asciisd\Autochartist\DTOs\NewsSentiment\SentimentRequest(search: 'AAPL')
        );
        $this->assertArrayHasKey('sentiments', $sentiment);

        // Get history
        $history = Autochartist::newsSentiment()->getHistory(
            new \Asciisd\Autochartist\DTOs\NewsSentiment\HistoryRequest(ticker: 'AAPL')
        );
        $this->assertArrayHasKey('history', $history);

        // Get sectors
        $sectors = Autochartist::newsSentiment()->getSectors();
        $this->assertArrayHasKey('sectors', $sectors);
    }
}
