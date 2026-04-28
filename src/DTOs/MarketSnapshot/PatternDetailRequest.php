<?php

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

/**
 * Market Snapshot Pattern Detail Request
 *
 * Retrieves detailed information about a specific pattern from snapshot
 */
readonly class PatternDetailRequest
{
    public function __construct(
        public int $reportId,
        public string $reportUid,
        public string $symbolReportId,
        public ?string $expire = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'report_id' => $this->reportId,
            'reportuid' => $this->reportUid,
            'symbol_report_id' => $this->symbolReportId,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return "/mr/api/reports/{$this->reportUid}/{$this->symbolReportId}/pattern_detail";
    }
}