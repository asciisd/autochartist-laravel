<?php

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

/**
 * Market Snapshot Request DTO
 *
 * Fetches a specific market snapshot with trading opportunities
 * Generated 3x daily before Tokyo, London, and New York sessions
 */
readonly class SnapshotRequest
{
    public function __construct(
        public int $reportId,
        public string $reportUid = 'latest',
        public ?array $include = null,
        public ?string $locale = null,
    ) {}

    public function toArray(): array
    {
        $params = array_filter([
            'report_id' => $this->reportId,
            'reportuid' => $this->reportUid,
            'locale' => $this->locale,
        ], fn ($value) => $value !== null);

        // Handle include parameter (can be multiple)
        if ($this->include && count($this->include) > 0) {
            // The API accepts multiple 'include' parameters
            // We'll handle this specially in the service
            $params['include'] = $this->include;
        }

        return $params;
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        // If reportUid is 'latest', use simpler path
        if ($this->reportUid === 'latest') {
            return "/mr/api/reports/{$this->reportId}/latest";
        }

        return "/mr/api/reports/{$this->reportId}/{$this->reportUid}";
    }
}
