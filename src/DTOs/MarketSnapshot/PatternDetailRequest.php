<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Market Snapshot Pattern Detail Request
 *
 * Retrieves detailed information about a specific pattern from snapshot
 */
readonly class PatternDetailRequest extends BaseDTO
{
    public function __construct(
        public int $reportId,
        public string $reportUid,
        public string $symbolReportId,
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
        return "/mr/api/reports/{$this->reportUid}/{$this->symbolReportId}/pattern_detail";
    }
}