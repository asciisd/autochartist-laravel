<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\NewsSentiment;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Extreme Score Change Request DTO
 *
 * Fetches extreme score changes (changes by 30+ points).
 */
readonly class ExtremeScoreChangeRequest extends BaseDTO
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
        return '/newssentiment/extreme_score_change';
    }
}