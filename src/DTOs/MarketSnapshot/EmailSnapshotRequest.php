<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Market Snapshot Email Render Request
 *
 * Retrieves HTML-rendered version of snapshot for email
 */
readonly class EmailSnapshotRequest extends BaseDTO
{
    public function __construct(
        public int $reportId,
        public string $reportUid = 'latest',
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
        return "/mr/api/reports/{$this->reportUid}/email";
    }
}