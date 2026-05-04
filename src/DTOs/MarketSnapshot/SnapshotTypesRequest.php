<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Market Snapshot Types Request DTO
 *
 * Fetches available report types (e.g., AutochartistFxDemo)
 */
readonly class SnapshotTypesRequest extends BaseDTO
{
    public function toArray(): array
    {
        return [];
    }
}
