<?php

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

/**
 * Market Snapshot Types Request DTO
 *
 * Fetches available report types (e.g., AutochartistFxDemo)
 */
readonly class SnapshotTypesRequest
{
    public function __construct()
    {
        // No additional parameters needed beyond authentication
    }

    public function toArray(): array
    {
        return [];
    }
}
