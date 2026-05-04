<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Feature;

use Asciisd\Autochartist\Exceptions\AutochartistException;
use Asciisd\Autochartist\Services\TechnicalAnalysisService;
use Asciisd\Autochartist\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ErrorHandlingTest extends TestCase
{
    public function test_throws_exception_on_http_error(): void
    {
        Http::fake([
            '*' => Http::response(['error' => 'Unauthorized'], 401),
        ]);

        $service = app(TechnicalAnalysisService::class);

        $this->expectException(AutochartistException::class);
        $this->expectExceptionMessage('API request failed');

        $service->getTradeSetups();
    }

    public function test_throws_exception_on_network_error(): void
    {
        Http::fake([
            '*' => Http::response(null, 500),
        ]);

        $service = app(TechnicalAnalysisService::class);

        $this->expectException(AutochartistException::class);

        $service->getTradeSetups();
    }

    public function test_handles_empty_response_gracefully(): void
    {
        Http::fake([
            '*' => Http::response(null, 200),
        ]);

        $service = app(TechnicalAnalysisService::class);
        $result = $service->getTradeSetups();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}
