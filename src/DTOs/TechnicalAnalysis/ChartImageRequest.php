<?php

namespace Mohanad\Autochartist\DTOs\TechnicalAnalysis;

class ChartImageRequest
{
    public function __construct(
        public readonly string $type,
        public readonly string $uid,
        public readonly ?int $width = 320,
        public readonly ?int $height = 240,
        public readonly ?string $locale = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'width' => $this->width,
            'height' => $this->height,
            'locale' => $this->locale,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the chart image path.
     */
    public function getPath(): string
    {
        return "/to/resources/charts/{$this->type}_{$this->uid}.png";
    }
}
