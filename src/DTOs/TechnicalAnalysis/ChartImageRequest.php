<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\TechnicalAnalysis;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Chart Image Request DTO
 *
 * Generates chart image URL for a specific technical pattern.
 */
readonly class ChartImageRequest extends BaseDTO
{
    public function __construct(
        public string $type,
        public string $uid,
        public ?int $width = 320,
        public ?int $height = 240,
        public ?string $locale = null,
    ) {}

    public function toArray(): array
    {
        // Exclude type and uid as they're used in the path, not query params
        $data = $this->toSnakeCaseArray();
        unset($data['type'], $data['uid']);
        
        return $data;
    }

    public function getPath(): string
    {
        return "/to/resources/charts/{$this->type}_{$this->uid}.png";
    }
}