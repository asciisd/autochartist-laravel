<?php

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

/**
 * Market Snapshot Email Render Request
 *
 * Retrieves HTML-rendered version of snapshot for email
 */
readonly class EmailSnapshotRequest
{
    public function __construct(
        public int $reportId,
        public string $reportUid = 'latest',
        public ?string $locale = null,
        public ?string $expire = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'report_id' => $this->reportId,
            'reportuid' => $this->reportUid,
            'locale' => $this->locale,
            'expire' => $this->expire,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return "/mr/api/reports/{$this->reportUid}/email";
    }
}