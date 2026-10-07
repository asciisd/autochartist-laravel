<?php

namespace Asciisd\AutochartistLaravel\Tests;

use Asciisd\AutochartistLaravel\Exceptions\AutochartistException;
use Asciisd\AutochartistLaravel\Services\AutochartistClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

class AutochartistClientTest extends TestCase
{
    public function test_it_applies_the_configured_timeout(): void
    {
        config(['autochartist.timeout' => 7]);

        $appliedTimeout = null;

        Http::fake(function (Request $request, array $options) use (&$appliedTimeout) {
            $appliedTimeout = $options['timeout'] ?? null;

            return Http::response(['ok' => true]);
        });

        $result = $this->app->make(AutochartistClient::class)->get('some/path');

        $this->assertSame(['ok' => true], $result);
        $this->assertSame(7, $appliedTimeout);
    }

    public function test_the_timeout_defaults_to_ten_seconds(): void
    {
        $appliedTimeout = null;

        Http::fake(function (Request $request, array $options) use (&$appliedTimeout) {
            $appliedTimeout = $options['timeout'] ?? null;

            return Http::response([]);
        });

        $this->app->make(AutochartistClient::class)->get('some/path');

        $this->assertSame(10, $appliedTimeout);
    }

    public function test_a_connection_failure_is_raised_as_an_autochartist_exception(): void
    {
        Http::fake(['*' => Http::failedConnection('cURL error 28: Operation timed out')]);

        try {
            $this->app->make(AutochartistClient::class)->get('some/path');
            $this->fail('Expected an AutochartistException.');
        } catch (AutochartistException $exception) {
            $this->assertStringContainsString('cURL error 28', $exception->getMessage());
            $this->assertInstanceOf(ConnectionException::class, $exception->getPrevious());
        }
    }

    public function test_an_error_response_is_still_raised_as_request_failed(): void
    {
        Http::fake(['*' => Http::response('boom', 500)]);

        $this->expectException(AutochartistException::class);
        $this->expectExceptionMessage('Autochartist request failed with status [500]: boom');

        $this->app->make(AutochartistClient::class)->get('some/path');
    }
}
