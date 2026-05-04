<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\MarketSnapshot;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Market Snapshot Instances Request DTO
 *
 * Fetches available snapshot instances with uid, generated date, and session info
 */
readonly class SnapshotInstancesRequest extends BaseDTO
{
    public function toArray(): array
    {
        return [];
    }
}
