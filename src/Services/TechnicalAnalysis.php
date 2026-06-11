<?php

namespace Asciisd\AutochartistLaravel\Services;

class TechnicalAnalysis extends AbstractService
{
    /**
     * Fetch technical analysis trade setups.
     *
     * @param  array<string, mixed>  $query
     * @return array<mixed>
     */
    public function technicalTradeSetups(array $query = []): array
    {
        return $this->client->get('to/resources/results', $query);
    }

    public function getPatternResultDetails(string $type, string $uid): array
    {
        return $this->client->get("to/resources/results/details/{$type}/{$uid}");
    }
}
