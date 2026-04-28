<?php

namespace Asciisd\Autochartist\DTOs\NewsSentiment;

class HistoryRequest
{
    public function __construct(
        public readonly string $ticker,
        public readonly ?string $daysBack = null,
        public readonly ?string $expire = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'ticker' => $this->ticker,
            'days_back' => $this->daysBack,
            'expire' => $this->expire,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return '/newssentiment/history';
    }
}