<?php

namespace Asciisd\AutochartistLaravel\Services;

class PerformanceStatisticsService extends AbstractService
{
    public function getPerformanceStatistics(array $query = []): array
    {
        return $this->client->get('get_performance_stats/resources', $query);
    }
}