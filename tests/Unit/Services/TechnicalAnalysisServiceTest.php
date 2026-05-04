<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Unit\Services;

use Asciisd\Autochartist\DTOs\TechnicalAnalysis\ChartImageRequest;
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\DrawingDataRequest;
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\PatternDetailRequest;
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\TradeSetupsRequest;
use Asciisd\Autochartist\Services\TechnicalAnalysisService;
use Asciisd\Autochartist\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class TechnicalAnalysisServiceTest extends TestCase
{
    private TechnicalAnalysisService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(TechnicalAnalysisService::class);
    }

    public function test_get_trade_setups_returns_array(): void
    {
        $expectedResponse = [
            'results' => [
                ['id' => 1, 'symbol' => 'EURUSD', 'pattern' => 'Triangle'],
                ['id' => 2, 'symbol' => 'GBPUSD', 'pattern' => 'Channel'],
            ],
        ];

        Http::fake([
            '*/to/resources/results*' => Http::response($expectedResponse),
        ]);

        $result = $this->service->getTradeSetups();

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_trade_setups_with_request_parameters(): void
    {
        $expectedResponse = ['results' => []];

        Http::fake([
            '*/to/resources/results*' => Http::response($expectedResponse),
        ]);

        $request = new TradeSetupsRequest();

        $result = $this->service->getTradeSetups($request);

        $this->assertEquals($expectedResponse, $result);
        
        Http::assertSent(function ($request) {
            return str_contains($request->url(), '/to/resources/results');
        });
    }

    public function test_get_pattern_detail_returns_array(): void
    {
        $expectedResponse = [
            'pattern' => [
                'id' => '123',
                'type' => 'Triangle',
                'quality' => 8,
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new PatternDetailRequest(type: 'pattern', uid: '123');
        $result = $this->service->getPatternDetail($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_drawing_data_returns_array(): void
    {
        $expectedResponse = [
            'drawing' => [
                'lines' => [],
                'points' => [],
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new DrawingDataRequest(type: 'pattern', uid: '123');
        $result = $this->service->getDrawingData($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_chart_image_url_returns_string(): void
    {
        $request = new ChartImageRequest(type: 'pattern', uid: '123');
        $url = $this->service->getChartImageUrl($request);

        $this->assertIsString($url);
        $this->assertStringContainsString('https://api.autochartist.com', $url);
        $this->assertStringContainsString('123', $url);
    }
}
