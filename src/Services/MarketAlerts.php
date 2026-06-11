<?php

namespace Asciisd\AutochartistLaravel\Services;

class MarketAlerts extends AbstractService
{

    /**
     * The time zone to use for market alerts.
     */
    protected string $timeZone = 'UTC';
    protected string $locale = 'en';
    protected string $include_detail = 'true';
    protected string $include_drawing = 'true';

    /**
     * Get market alerts.
     *
     * @param  array<string, mixed>  $query
     * @return array<mixed>
     */
    public function getMarketAlerts(array $query = []): array
    {
        $query = array_merge($query, [
            'time_zone' => $this->timeZone,
            'locale' => $this->locale,
            'include_detail' => $this->include_detail,
            'include_drawing' => $this->include_drawing,
        ]);

        return $this->client->get('ma/resources/results', $query);
    }
}