<?php

namespace Mohanad\Autochartist\DTOs\NewsSentiment;

class HistoryRequest
{
    public function __construct(
        public readonly string $ticker,
        public readonly ?string $dateFrom = null,
        public readonly ?string $dateTo = null,
        public readonly ?int $limit = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'ticker' => $this->ticker,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
            'limit' => $this->limit,
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
