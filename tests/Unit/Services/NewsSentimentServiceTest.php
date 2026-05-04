<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Unit\Services;

use Asciisd\Autochartist\DTOs\NewsSentiment\ExtremeScoreChangeRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\HistoryRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SentimentRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SignificantSentimentRequest;
use Asciisd\Autochartist\Services\NewsSentimentService;
use Asciisd\Autochartist\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class NewsSentimentServiceTest extends TestCase
{
    private NewsSentimentService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(NewsSentimentService::class);
    }

    public function test_get_sentiment_returns_array(): void
    {
        $expectedResponse = [
            'sentiments' => [
                ['ticker' => 'AAPL', 'score' => 75],
                ['ticker' => 'GOOGL', 'score' => 82],
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $result = $this->service->getSentiment();

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_sentiment_with_tickers(): void
    {
        $expectedResponse = ['sentiments' => []];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new SentimentRequest(search: 'AAPL,GOOGL');
        $result = $this->service->getSentiment($request);

        $this->assertEquals($expectedResponse, $result);
        
        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'AAPL') 
                && str_contains($request->url(), 'GOOGL');
        });
    }

    public function test_get_extreme_score_change_returns_array(): void
    {
        $expectedResponse = [
            'changes' => [
                ['ticker' => 'TSLA', 'change' => 35],
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new ExtremeScoreChangeRequest(dateInput: '2026-05-04');
        $result = $this->service->getExtremeScoreChange($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_significant_sentiment_returns_array(): void
    {
        $expectedResponse = [
            'significant' => [
                ['ticker' => 'MSFT', 'sentiment' => 'very_positive'],
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new SignificantSentimentRequest(dateInput: '2026-05-04');
        $result = $this->service->getSignificantSentiment($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_history_returns_array(): void
    {
        $expectedResponse = [
            'history' => [
                ['date' => '2026-05-01', 'score' => 70],
                ['date' => '2026-05-02', 'score' => 75],
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new HistoryRequest(ticker: 'AAPL');
        $result = $this->service->getHistory($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_sectors_returns_array(): void
    {
        $expectedResponse = [
            'sectors' => [
                ['id' => 1, 'name' => 'Technology'],
                ['id' => 2, 'name' => 'Finance'],
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $result = $this->service->getSectors();

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_sources_returns_array(): void
    {
        $expectedResponse = [
            'sources' => [
                ['id' => 1, 'name' => 'Reuters'],
                ['id' => 2, 'name' => 'Bloomberg'],
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $result = $this->service->getSources();

        $this->assertEquals($expectedResponse, $result);
    }
}
