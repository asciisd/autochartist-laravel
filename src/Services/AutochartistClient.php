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
     * @param  string|null  $baseUrl  Override the configured base URL for this request.
     * @return array<mixed>
     *
     * @throws AutochartistException
     */
    public function get(string $path, array $query = [], ?string $baseUrl = null): array
    {
        $response = Http::get(
            $this->buildUrl($path, $baseUrl),
            $this->parameters($query)
        );

        if ($response->failed()) {
            throw AutochartistException::requestFailed($response->status(), $response->body());
        }

        return $response->json() ?? [];
    }

    /**
     * Build a fully signed, authenticated URL without performing a request.
     *
     * Useful for endpoints that are embedded directly (e.g. iframes) rather
     * than fetched server-side.
     *
     * @param  array<string, mixed>  $query
     * @param  string|null  $baseUrl  Override the configured base URL.
     *
     * @throws AutochartistException
     */
    public function signedUrl(string $path, array $query = [], ?string $baseUrl = null): string
    {
        return $this->buildUrl($path, $baseUrl)
            . '?' . http_build_query($this->parameters($query));
    }

    /**
     * Merge the request query with the style flag and authentication credentials.
     *
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     *
     * @throws AutochartistException
     */
    private function parameters(array $query): array
    {
        if (config('autochartist.style') === 'dark') {
            $query['style'] = 'ds';
        }

        return array_merge($query, $this->authenticator->credentials());
    }

    /**
     * Join the base URL with the endpoint path using a single slash.
     *
     * When no base URL is provided, the configured default is used.
     */
    public function buildUrl(string $path, ?string $baseUrl = null): string
    {
        $base = rtrim($baseUrl ?? (string) config('autochartist.url'), '/');

        return $base . '/' . ltrim($path, '/');
    }
}
