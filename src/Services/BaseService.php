<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Services;

use Asciisd\Autochartist\DTOs\BaseDTO;
use Asciisd\Autochartist\Exceptions\AutochartistException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

/**
 * Base Service
 *
 * Provides common HTTP functionality and authentication for all API services.
 */
abstract class BaseService
{
    private const TIMEOUT_SECONDS = 120;

    public function __construct(
        protected readonly AuthenticationService $auth
    ) {}

    /**
     * Make GET request to API.
     */
    protected function get(string $endpoint, array $params = []): array
    {
        return $this->request(fn () => $this->client()->get($endpoint, $params));
    }

    /**
     * Make POST request to API.
     */
    protected function post(string $endpoint, array $data = []): array
    {
        return $this->request(fn () => $this->client()->post($endpoint, $data));
    }

    /**
     * Build query parameters with authentication.
     */
    protected function buildQuery(BaseDTO $request, bool $includeAccountType = true): array
    {
        $authParams = $this->auth->getAuthParams($includeAccountType);

        return array_merge($authParams, $request->toArray());
    }

    /**
     * Build full URL with query string.
     */
    protected function buildUrl(string $path, array $query): string
    {
        $queryString = $this->buildQueryString($query);

        return config('autochartist.base_url').$path.'?'.$queryString;
    }

    /**
     * Build query string handling array parameters properly.
     */
    protected function buildQueryString(array $params): string
    {
        $parts = [];

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $parts[] = urlencode((string) $key).'='.urlencode((string) $item);
                }
            } else {
                $parts[] = urlencode((string) $key).'='.urlencode((string) $value);
            }
        }

        return implode('&', $parts);
    }

    /**
     * Execute HTTP request with error handling.
     */
    private function request(callable $callback): array
    {
        try {
            $response = $callback()->throw();

            return $response->json() ?? [];
        } catch (RequestException $e) {
            throw new AutochartistException(
                "API request failed: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get configured HTTP client.
     */
    private function client()
    {
        return Http::baseUrl(config('autochartist.base_url'))
            ->acceptJson()
            ->timeout(self::TIMEOUT_SECONDS);
    }
}