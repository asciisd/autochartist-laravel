<?php

namespace Asciisd\AutochartistLaravel\Services;

use Asciisd\AutochartistLaravel\Exceptions\AutochartistException;
use Illuminate\Support\Facades\Http;

class AutochartistClient
{
    public function __construct(private AutochartistAuthenticator $authenticator)
    {
    }

    /**
     * Perform an authenticated GET request against the Autochartist API.
     *
     * @param  array<string, mixed>  $query
     * @return array<mixed>
     *
     * @throws AutochartistException
     */
    public function get(string $path, array $query = []): array
    {
        if (config('autochartist.style') === 'dark') {
            $query['style'] = 'ds';
        }

        $response = Http::get(
            $this->buildUrl($path),
            array_merge($query, $this->authenticator->credentials())
        );

        if ($response->failed()) {
            throw AutochartistException::requestFailed($response->status(), $response->body());
        }

        return $response->json() ?? [];
    }

    /**
     * Join the configured base URL with the endpoint path using a single slash.
     */
    private function buildUrl(string $path): string
    {
        $base = rtrim((string) config('autochartist.url'), '/');

        return $base . '/' . ltrim($path, '/');
    }
}
