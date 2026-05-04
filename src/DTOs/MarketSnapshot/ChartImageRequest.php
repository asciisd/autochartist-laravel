<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Market Snapshot Chart Image Request
 *
 * Retrieves chart image for a specific symbol_report_id from snapshot
 */
readonly class ChartImageRequest extends BaseDTO
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
    ) {}

    public function toArray(): array
    {
        $data = $this->toSnakeCaseArray();
        
        // Custom mappings for API
        if (isset($data['width'])) {
            $data['w'] = $data['width'];
            unset($data['width']);
        }
        if (isset($data['height'])) {
            $data['h'] = $data['height'];
            unset($data['height']);
        }
        if (isset($data['report_uid'])) {
            $data['reportuid'] = $data['report_uid'];
            unset($data['report_uid']);
        }
        
        // Remove fields used in path
        unset($data['image_format']);
        
        return $data;
    }

    public function getPath(): string
    {
        return "/mr/api/reports/{$this->reportUid}/{$this->symbolReportId}.{$this->imageFormat}";
    }
}