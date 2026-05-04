<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Market Snapshot Request DTO
 *
 * Fetches a specific market snapshot with trading opportunities
 * Generated 3x daily before Tokyo, London, and New York sessions
 */
readonly class SnapshotRequest extends BaseDTO
{
    public function __construct(
        public int $reportId,
        public string $reportUid = 'latest',
        public ?array $include = null,
        public ?string $locale = null,
    ) {}

    public function toArray(): array
    {
        $data = $this->toSnakeCaseArray();
        
        // reportuid needs to be lowercase without underscore
        if (isset($data['report_uid'])) {
            $data['reportuid'] = $data['report_uid'];
            unset($data['report_uid']);
        }
        
        return $data;
    }

    public function getPath(): string
    {
        if ($this->reportUid === 'latest') {
            return "/mr/api/reports/{$this->reportId}/latest";
        }

        return "/mr/api/reports/{$this->reportId}/{$this->reportUid}";
    }
}
