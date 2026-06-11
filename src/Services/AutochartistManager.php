<?php

namespace Asciisd\AutochartistLaravel\Services;

class AutochartistManager
{
    public function __construct(
        private TechnicalAnalysis $technicalAnalysis,
        private MarketAlerts $marketAlerts
    ) {
    }

    public function technicalAnalysis(): TechnicalAnalysis
    {
        return $this->technicalAnalysis;
    }

    public function marketAlerts(): MarketAlerts
    {
        return $this->marketAlerts;
    }
}
