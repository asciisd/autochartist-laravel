<?php

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

/**
 * Market Snapshot Instances Request DTO
 *
 * Fetches available snapshot instances with uid, generated date, and session info
 */
readonly class SnapshotInstancesRequest
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
