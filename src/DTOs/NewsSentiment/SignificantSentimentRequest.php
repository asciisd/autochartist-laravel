<?php

namespace Mohanad\Autochartist\DTOs\NewsSentiment;

class SignificantSentimentRequest
{
    public function __construct(
        public readonly string $dateInput,
    ) {}

    public function toArray(): array
    {
        return [
            'date_input' => $this->dateInput,
        ];
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return '/newssentiment/significant_sentiment';
    }
}
