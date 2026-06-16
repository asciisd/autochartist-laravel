<?php

namespace Asciisd\AutochartistLaravel\Services;

class TechnicalAnalysisService extends AbstractService
{
    /**
     * Get technical analysis trade setups.
     *
     * @param  array<string, mixed>  $query
     * @return array<mixed>
     */
    public function technicalTradeSetups(array $query = []): array
    {
        return response()->json(
            [
                'data' => $this->client->get('to/resources/results', $query),
            ],
            200
        );
    }

    /**
     * Get pattern result details.
     *
     * @param string $type
     * @param string $uid
     * @return array<mixed>
     */
    public function getPatternResultDetails(string $type, string $uid): array
    {
        return response()->json(
            [
                'data' => $this->client->get("to/resources/results/details/{$type}/{$uid}"),
            ],
            200
        );
    }
}
