<?php

namespace Mohanad\Autochartist\Services;

use Mohanad\Autochartist\Contracts\AutochartistClientInterface;
use Mohanad\Autochartist\DTOs\MarketSnapshot\ChartImageRequest;
use Mohanad\Autochartist\DTOs\MarketSnapshot\EmailSnapshotRequest;
use Mohanad\Autochartist\DTOs\MarketSnapshot\PatternDetailRequest;
use Mohanad\Autochartist\DTOs\MarketSnapshot\SnapshotInstancesRequest;
use Mohanad\Autochartist\DTOs\MarketSnapshot\SnapshotRequest;
use Mohanad\Autochartist\DTOs\MarketSnapshot\SnapshotTypesRequest;
use Mohanad\Autochartist\Traits\HasAuthentication;

/**
 * Market Snapshot Service
 *
 * Provides market snapshots generated 3x daily before:
 * - Tokyo Session (AS)
 * - London Session (EU)
 * - New York Session (US)
 */
class MarketSnapshotService
{
    use HasAuthentication;

    private const ENDPOINT_SNAPSHOT_TYPES = '/mr/api/reports/types';

    private const ENDPOINT_SNAPSHOT_INSTANCES = '/mr/api/reports/';

    public function __construct(
        private readonly AutochartistClientInterface $client
    ) {}

    /**
     * Get available snapshot types (report types).
     *
     * Returns list of available reports with:
     * - report_id: ID to use in subsequent calls
     * - name: Report name
     * - last_updated: Last update timestamp
     */
    public function getSnapshotTypes(SnapshotTypesRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams(request('expire')),
            $request->toArray()
        );

        return $this->client->get(self::ENDPOINT_SNAPSHOT_TYPES, $query);
    }

    /**
     * Get available snapshot instances.
     *
     * Returns list of available report instances with:
     * - report_id: Report type ID
     * - report_uid: Unique instance identifier
     * - generated: Generation timestamp
     * - session: Trading session (US/EU/AS)
     */
    public function getSnapshotInstances(SnapshotInstancesRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        // dd(self::ENDPOINT_SNAPSHOT_INSTANCES, $query);

        return $this->client->get(self::ENDPOINT_SNAPSHOT_INSTANCES, $query);
    }

    /**
     * Get a specific market snapshot.
     *
     * Returns snapshot with:
     * - report_id, report_uid, generated, session
     * - messages: Market snapshot description, dates, etc.
     * - symbol_reports: Trading opportunities with levels, analysis, etc.
     *
     * @param  SnapshotRequest  $request  Request with reportId, reportUid (or 'latest'), include options, locale
     */
    public function getSnapshot(SnapshotRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        // Handle multiple 'include' parameters
        if (isset($query['include']) && is_array($query['include'])) {
            $includes = $query['include'];
            unset($query['include']);

            // Build query string with multiple include parameters
            $queryString = http_build_query($query);
            foreach ($includes as $include) {
                $queryString .= '&include='.$include;
            }

            // Make request with custom query string
            $endpoint = $request->getPath().'?'.$queryString;

            return $this->client->get($endpoint, []);
        }

        return $this->client->get($request->getPath(), $query);
    }

    /**
     * Get chart image URL for a specific symbol report from snapshot.
     *
     * @param  ChartImageRequest  $request  Request with symbolReportId, dimensions, locale
     * @return string Chart image URL
     */
    public function getChartImageUrl(ChartImageRequest $request): string
    {
        $query = array_merge(
            $this->getDefaultParams(),
            $request->toArray()
        );

        $baseUrl = config('autochartist.base_url');
        $queryString = http_build_query($query);

        return $baseUrl.$request->getPath().'?'.$queryString;
    }

    /**
     * Get detailed pattern information for a specific symbol report.
     *
     * Returns pattern details including:
     * - Pattern type and identification time
     * - Chart data points
     * - Support/resistance levels
     * - Technical indicators
     *
     * @param  PatternDetailRequest  $request  Request with symbolReportId, locale
     */
    public function getPatternDetail(PatternDetailRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams(),
            $request->toArray()
        );

        return $this->client->get($request->getPath(), $query);
    }

    /**
     * Get HTML-rendered snapshot for email.
     *
     * Returns complete HTML email template with embedded images and styling.
     *
     * @param  EmailSnapshotRequest  $request  Request with reportId, reportUid (or 'latest'), locale
     * @return array HTML content and metadata
     */
    public function getEmailSnapshot(EmailSnapshotRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        return $this->client->get($request->getPath(), $query);
    }
}