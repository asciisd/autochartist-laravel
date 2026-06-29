<?php

namespace Asciisd\AutochartistLaravel\Services;

class EconomicCalendar extends AbstractService
{
    /**
     * Build the signed Economic Calendar URL for embedding (e.g. in an iframe).
     *
     * The calendar is served from a dedicated host (config: autochartist.eia_url)
     * that differs from the main Autochartist API base URL.
     */
    public function getEconomicCalendar(array $query = []): string
    {
        return $this->client->signedUrl(
            path: 'calendar/',
            query: $query,
            baseUrl: (string) config('autochartist.eia_url'),
        );
    }
}