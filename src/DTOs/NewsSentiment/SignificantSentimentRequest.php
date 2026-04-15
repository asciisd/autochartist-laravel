<?php

namespace Mohanad\Autochartist\DTOs\NewsSentiment;

class SignificantSentimentRequest
{
    public function __construct(
        public readonly string $dateInput,
        public readonly ?string $expire = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'date_input' => $this->dateInput,
            'expire' => $this->expire,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return '/newssentiment/significant_sentiment';
    }
}