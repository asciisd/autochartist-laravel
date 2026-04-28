<?php

namespace Asciisd\Autochartist\Http;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Asciisd\Autochartist\Contracts\AutochartistClientInterface;
use Asciisd\Autochartist\Exceptions\AutochartistException;

class AutochartistHttpClient implements AutochartistClientInterface
{
    private const TIMEOUT_SECONDS = 120;

    public function get(string $endpoint, array $params = []): array
    {
        try {
            $response = $this->client()->get($endpoint, $params)->throw();

            return $response->json() ?? [];
        } catch (RequestException $e) {
            throw new AutochartistException("GET $endpoint failed: ".$e->getMessage(), $e->getCode(), $e);
        }
    }

    public function post(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->client()->post($endpoint, $data)->throw();

            return $response->json() ?? [];
        } catch (RequestException $e) {
            throw new AutochartistException("POST $endpoint failed: ".$e->getMessage(), $e->getCode(), $e);
        }
    }

    private function client()
    {
        $baseUrl = config('autochartist.base_url');

        return Http::baseUrl($baseUrl)
            ->acceptJson()
            ->timeout(self::TIMEOUT_SECONDS);
    }
}
