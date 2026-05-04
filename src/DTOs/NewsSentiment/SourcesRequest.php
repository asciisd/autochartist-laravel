<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\NewsSentiment;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Sources Request DTO
 *
 * Fetches available news sources.
 */
readonly class SourcesRequest extends BaseDTO
{
    public function toArray(): array
    {
        return [];
    }

    public function getPath(): string
    {
        return '/newssentiment/sources';
    }
}