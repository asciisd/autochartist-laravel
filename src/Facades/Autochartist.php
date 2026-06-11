<?php

namespace Asciisd\AutochartistLaravel\Facades;

use Asciisd\AutochartistLaravel\Services\AutochartistManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Asciisd\AutochartistLaravel\Services\TechnicalAnalysis technicalAnalysis()
 *
 * @see \Asciisd\AutochartistLaravel\Services\AutochartistManager
 */
class Autochartist extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AutochartistManager::class;
    }
}
