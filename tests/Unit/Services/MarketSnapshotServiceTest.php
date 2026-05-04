<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Tests\Unit\Services;

use Asciisd\Autochartist\DTOs\MarketSnapshot\ChartImageRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\EmailSnapshotRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\PatternDetailRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotInstancesRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotTypesRequest;
use Asciisd\Autochartist\Services\MarketSnapshotService;
use Asciisd\Autochartist\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class MarketSnapshotServiceTest extends TestCase
{
    private MarketSnapshotService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(MarketSnapshotService::class);
    }

    public function test_get_snapshot_types_returns_array(): void
    {
        $expectedResponse = [
            'report_types' => [
                ['id' => 1, 'name' => 'Type 1'],
                ['id' => 2, 'name' => 'Type 2'],
            ],
        ];

        Http::fake([
            '*/mr/api/reports/types*' => Http::response($expectedResponse),
        ]);

        $request = new SnapshotTypesRequest();
        $result = $this->service->getSnapshotTypes($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_snapshot_instances_returns_array(): void
    {
        $expectedResponse = [
            'instances' => [
                ['id' => 1, 'date' => '2026-05-01'],
                ['id' => 2, 'date' => '2026-05-02'],
            ],
        ];

        Http::fake([
            '*/mr/api/reports/*' => Http::response($expectedResponse),
        ]);

        $request = new SnapshotInstancesRequest();
        $result = $this->service->getSnapshotInstances($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_snapshot_returns_array(): void
    {
        $expectedResponse = [
            'snapshot' => [
                'data' => 'test data',
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new SnapshotRequest(
            reportId: 123
        );
        
        $result = $this->service->getSnapshot($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_chart_image_url_returns_string(): void
    {
        $request = new ChartImageRequest(
            reportId: 123,
            reportUid: 'latest',
            symbolReportId: '789'
        );

        $url = $this->service->getChartImageUrl($request);

        $this->assertIsString($url);
        $this->assertStringContainsString('https://api.autochartist.com', $url);
        $this->assertStringContainsString('123', $url);
        $this->assertStringContainsString('789', $url);
    }

    public function test_get_pattern_detail_returns_array(): void
    {
        $expectedResponse = [
            'pattern' => [
                'id' => '789',
                'type' => 'triangle',
            ],
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new PatternDetailRequest(
            reportId: 123,
            reportUid: 'latest',
            symbolReportId: '789'
        );

        $result = $this->service->getPatternDetail($request);

        $this->assertEquals($expectedResponse, $result);
    }

    public function test_get_email_snapshot_returns_array(): void
    {
        $expectedResponse = [
            'html' => '<html>...</html>',
        ];

        Http::fake([
            '*' => Http::response($expectedResponse),
        ]);

        $request = new EmailSnapshotRequest(
            reportId: 123
        );

        $result = $this->service->getEmailSnapshot($request);

        $this->assertEquals($expectedResponse, $result);
    }
}