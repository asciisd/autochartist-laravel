<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Services;

use Asciisd\Autochartist\DTOs\MarketSnapshot\ChartImageRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\EmailSnapshotRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\PatternDetailRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotInstancesRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotRequest;
use Asciisd\Autochartist\DTOs\MarketSnapshot\SnapshotTypesRequest;

/**
 * Market Snapshot Service
 *
 * Provides market snapshots generated 3x daily before:
 * - Tokyo Session (AS)
 * - London Session (EU)
 * - New York Session (US)
 */
final class MarketSnapshotService extends BaseService
{
    private const ENDPOINT_SNAPSHOT_TYPES = '/mr/api/reports/types';
    private const ENDPOINT_SNAPSHOT_INSTANCES = '/mr/api/reports/';

    /**
     * Get available snapshot types (report types).
     */
    public function getSnapshotTypes(SnapshotTypesRequest $request): array
    {
        $query = $this->buildQuery($request);

        return $this->get(self::ENDPOINT_SNAPSHOT_TYPES, $query);
    }

    /**
     * Get available snapshot instances.
     */
    public function getSnapshotInstances(SnapshotInstancesRequest $request): array
    {
        $query = $this->buildQuery($request);

        return $this->get(self::ENDPOINT_SNAPSHOT_INSTANCES, $query);
    }

    /**
     * Get a specific market snapshot.
     */
    public function getSnapshot(SnapshotRequest $request): array
    {
        $query = $this->buildQuery($request);
        
        return $this->get($request->getPath(), $query);
    }

    /**
     * Get chart image URL for a specific symbol report from snapshot.
     */
    public function getChartImageUrl(ChartImageRequest $request): string
    {
        $query = $this->buildQuery($request);

        return $this->buildUrl($request->getPath(), $query);
    }

    /**
     * Get detailed pattern information for a specific symbol report.
     */
    public function getPatternDetail(PatternDetailRequest $request): array
    {
        $query = $this->buildQuery($request);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get HTML-rendered snapshot for email.
     */
    public function getEmailSnapshot(EmailSnapshotRequest $request): array
    {
        $query = $this->buildQuery($request);

        return $this->get($request->getPath(), $query);
    }
}