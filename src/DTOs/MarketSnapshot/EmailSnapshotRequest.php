<?php

namespace Mohanad\Autochartist\DTOs\MarketSnapshot;

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
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'report_id' => $this->reportId,
            'locale' => $this->locale,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        if ($this->reportUid === 'latest') {
            return "/mr/api/reports/{$this->reportId}/latest/email";
        }

        return "/mr/api/reports/{$this->reportId}/{$this->reportUid}/email";
    }
}
