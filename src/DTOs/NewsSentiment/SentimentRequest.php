<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\NewsSentiment;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Sentiment Request DTO
 *
 * Fetches latest sentiment data for tickers.
 */
readonly class SentimentRequest extends BaseDTO
{
    public function __construct(
        public ?string $search = null,
        public ?string $sector = null,
        public ?string $sentiment = null,
        public ?bool $strongSentiment = null,
        public ?bool $includeDetail = null,
    ) {}

    public function toArray(): array
    {
        return $this->toSnakeCaseArray();
    }

    public function getPath(): string
    {
        return '/newssentiment/sentiment';
    }
}