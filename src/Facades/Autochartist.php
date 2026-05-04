<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Facades;

use Asciisd\Autochartist\AutochartistManager;
use Illuminate\Support\Facades\Facade;

/**
 * Autochartist Facade
 *
 * @method static \Asciisd\Autochartist\Services\MarketSnapshotService marketSnapshot()
 * @method static \Asciisd\Autochartist\Services\TechnicalAnalysisService technicalAnalysis()
 * @method static \Asciisd\Autochartist\Services\NewsSentimentService newsSentiment()
 *
 * @see \Asciisd\Autochartist\AutochartistManager
 */
final class Autochartist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AutochartistManager::class;
    }
}
