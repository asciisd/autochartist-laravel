<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\NewsSentiment;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Sectors Request DTO
 *
 * Fetches available news sentiment sectors.
 */
readonly class SectorsRequest extends BaseDTO
{
    public function toArray(): array
    {
        return [];
    }

    public function getPath(): string
    {
        return '/newssentiment/sectors';
    }
}