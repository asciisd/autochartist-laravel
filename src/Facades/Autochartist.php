<?php

namespace Asciisd\AutochartistLaravel\Facades;

use Asciisd\AutochartistLaravel\AutochartistManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Asciisd\AutochartistLaravel\Services\TechnicalAnalysisService technicalAnalysis()
 * @method static \Asciisd\AutochartistLaravel\Services\MarketAlertsService marketAlerts()
 * @method static \Asciisd\AutochartistLaravel\Services\NewsSentimentService newsSentiment()
 * @method static \Asciisd\AutochartistLaravel\Services\EconomicCalendarService economicCalendar()
 * @method static \Asciisd\AutochartistLaravel\Services\PerformanceStatisticsService performanceStatistics()
 * @see \Asciisd\AutochartistLaravel\AutochartistManager
 */
class Autochartist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AutochartistManager::class;
    }
}
