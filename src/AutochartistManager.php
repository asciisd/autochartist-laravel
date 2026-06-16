<?php

namespace Asciisd\AutochartistLaravel;

use Asciisd\AutochartistLaravel\Services\TechnicalAnalysisService;
use Asciisd\AutochartistLaravel\Services\MarketAlertsService;
use Asciisd\AutochartistLaravel\Services\NewsSentimentService;

class AutochartistManager
{
    public function __construct(
        private TechnicalAnalysisService $technicalAnalysis,
        private MarketAlertsService $marketAlerts,
        private NewsSentimentService $newsSentiment
    ) {
    }

    public function technicalAnalysis(): TechnicalAnalysisService
    {
        return $this->technicalAnalysis;
    }

    public function marketAlerts(): MarketAlertsService
    {
        return $this->marketAlerts;
    }

    public function newsSentiment(): NewsSentimentService
    {
        return $this->newsSentiment;
    }
}
