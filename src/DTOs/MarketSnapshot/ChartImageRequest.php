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
        public int $reportId,
        public string $reportUid,
        public string $symbolReportId,
        public string $imageFormat = 'png',
        public ?int $width = 430,
        public ?int $height = 300,
        public ?string $locale = null,
        public ?bool $small = null,
        public ?string $expire = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'report_id' => $this->reportId,
            'reportuid' => $this->reportUid,
            'symbol_report_id' => $this->symbolReportId,
            'w' => $this->width,
            'h' => $this->height,
            'small' => $this->small,
            'expire' => $this->expire,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return "/mr/api/reports/{$this->reportUid}/{$this->symbolReportId}.{$this->imageFormat}";
    }
}