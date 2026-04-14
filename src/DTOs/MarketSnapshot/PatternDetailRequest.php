<?php

namespace Mohanad\Autochartist\DTOs\MarketSnapshot;

/**
 * Market Snapshot Pattern Detail Request
 *
 * Retrieves detailed information about a specific pattern from snapshot
 */
readonly class PatternDetailRequest
{
    public function __construct(
        public string $symbolReportId,
        public ?string $locale = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'locale' => $this->locale,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return "/mr/api/pattern/{$this->symbolReportId}";
    }
}
