<?php

namespace Mohanad\Autochartist\Services;

use Mohanad\Autochartist\Contracts\AutochartistClientInterface;
use Mohanad\Autochartist\DTOs\TechnicalAnalysis\ChartImageRequest;
use Mohanad\Autochartist\DTOs\TechnicalAnalysis\PatternDetailRequest;
use Mohanad\Autochartist\DTOs\TechnicalAnalysis\TradeSetupsRequest;
use Mohanad\Autochartist\Traits\HasAuthentication;

class TechnicalAnalysisService
{
    use HasAuthentication;

    private const ENDPOINT_TRADE_SETUPS = '/to/resources/results';

    public function __construct(
        private readonly AutochartistClientInterface $client
    ) {}

    /**
     * Get technical trade setups (chart patterns, key levels, fibonacci).
     */
    public function getTradeSetups(?TradeSetupsRequest $request = null): array
    {
        $request = $request ?? new TradeSetupsRequest;

        $query = array_merge(
            $this->getDefaultParams(),
            $request->toArray()
        );

        return $this->client->get(self::ENDPOINT_TRADE_SETUPS, $query);
    }

    /**
     * Get detailed information for a specific pattern.
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
     * Get drawing data for a specific pattern.
     */
    public function getDrawingData(PatternDetailRequest $request): array
    {
        $query = $this->getDefaultParams();

        $path = "/to/resources/results/detail/drawing-data/{$request->type}/{$request->uid}";

        return $this->client->get($path, $query);
    }

    /**
     * Get chart image URL for a specific pattern.
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
}
