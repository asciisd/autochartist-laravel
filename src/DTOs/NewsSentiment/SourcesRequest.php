<?php

namespace Mohanad\Autochartist\DTOs\NewsSentiment;

class SourcesRequest
{
    public function __construct(
        public readonly ?string $expire = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'expire' => $this->expire,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return '/newssentiment/sources';
    }
}