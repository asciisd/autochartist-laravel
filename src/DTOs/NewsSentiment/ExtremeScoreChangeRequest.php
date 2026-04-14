<?php

namespace Mohanad\Autochartist\DTOs\NewsSentiment;

class ExtremeScoreChangeRequest
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
        return '/newssentiment/extreme_score_change';
    }
}
