<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\NewsSentiment;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * History Request DTO
 *
 * Fetches historical sentiment data for a specific ticker.
 */
readonly class HistoryRequest extends BaseDTO
{
    public function __construct(
        public string $ticker,
        public ?string $daysBack = null,
    ) {}

    public function toArray(): array
    {
        return $this->toSnakeCaseArray();
    }

    public function getPath(): string
    {
        return '/newssentiment/history';
    }
}