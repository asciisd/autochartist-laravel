<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\NewsSentiment;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Significant Sentiment Request DTO
 *
 * Fetches significant sentiments (very positive or very negative).
 */
readonly class SignificantSentimentRequest extends BaseDTO
{
    public function __construct(
        public string $dateInput,
    ) {}

    public function toArray(): array
    {
        return $this->toSnakeCaseArray();
    }

    public function getPath(): string
    {
        return '/newssentiment/significant_sentiment';
    }
}