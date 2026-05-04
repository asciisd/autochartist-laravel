<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\TechnicalAnalysis;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Drawing Data Request DTO
 *
 * Fetches drawing data for a specific pattern.
 */
readonly class DrawingDataRequest extends BaseDTO
{
    public function __construct(
        public string $type,
        public string $uid,
    ) {}

    public function toArray(): array
    {
        return [];
    }

    public function getPath(): string
    {
        return "/to/resources/results/detail/drawing-data/{$this->type}/{$this->uid}";
    }
}
