<?php

namespace Mohanad\Autochartist\DTOs\MarketSnapshot;

/**
 * Market Snapshot Chart Image Request
 *
 * Retrieves chart image for a specific symbol_report_id from snapshot
 */
readonly class ChartImageRequest
{
    public function __construct(
        public string $symbolReportId,
        public ?int $width = 430,
        public ?int $height = 300,
        public ?string $locale = null,
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
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return "/mr/api/charts/{$this->symbolReportId}";
    }
}
