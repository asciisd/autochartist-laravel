<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Services;

use Asciisd\Autochartist\DTOs\TechnicalAnalysis\ChartImageRequest;
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\DrawingDataRequest;
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\PatternDetailRequest;
use Asciisd\Autochartist\DTOs\TechnicalAnalysis\TradeSetupsRequest;

/**
 * Technical Analysis Service
 *
 * Provides real-time technical analysis including:
 * - Chart patterns (triangles, channels, head & shoulders)
 * - Fibonacci retracements
 * - Key levels (support/resistance)
 */
final class TechnicalAnalysisService extends BaseService
{
    private const ENDPOINT_TRADE_SETUPS = '/to/resources/results';

    /**
     * Get technical trade setups (chart patterns, key levels, fibonacci).
     */
    public function getTradeSetups(?TradeSetupsRequest $request = null): array
    {
        $request = $request ?? new TradeSetupsRequest();
        $query = $this->buildQuery($request);

        return $this->get(self::ENDPOINT_TRADE_SETUPS, $query);
    }

    /**
     * Get detailed information for a specific pattern.
     */
    public function getPatternDetail(PatternDetailRequest $request): array
    {
        $query = $this->buildQuery($request);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get drawing data for a specific pattern.
     */
    public function getDrawingData(DrawingDataRequest $request): array
    {
        $query = $this->buildQuery($request);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get chart image URL for a specific pattern.
     */
    public function getChartImageUrl(ChartImageRequest $request): string
    {
        $query = $this->buildQuery($request);

        return $this->buildUrl($request->getPath(), $query);
    }
}