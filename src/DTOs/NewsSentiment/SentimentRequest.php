<?php

namespace Mohanad\Autochartist\DTOs\NewsSentiment;

class SentimentRequest
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $sector = null,
        public readonly ?string $sentiment = null,
        public readonly ?bool $strongSentiment = null,
        public readonly ?bool $includeDetail = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'search' => $this->search,
            'sector' => $this->sector,
            'sentiment' => $this->sentiment,
            'strong_sentiment' => $this->strongSentiment,
            'include_detail' => $this->includeDetail,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return '/newssentiment/sentiment';
    }
}
