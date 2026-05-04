<?php

declare(strict_types=1);

namespace Asciisd\Autochartist;

use Asciisd\Autochartist\Services\MarketSnapshotService;
use Asciisd\Autochartist\Services\NewsSentimentService;
use Asciisd\Autochartist\Services\TechnicalAnalysisService;

/**
 * Autochartist Manager
 *
 * Central manager providing access to all Autochartist API services.
 */
final class AutochartistManager
{
    public function __construct(
        private readonly MarketSnapshotService $marketSnapshotService,
        private readonly TechnicalAnalysisService $technicalAnalysisService,
        private readonly NewsSentimentService $newsSentimentService
    ) {}

    public function marketSnapshot(): MarketSnapshotService
    {
        return $this->marketSnapshotService;
    }

    public function technicalAnalysis(): TechnicalAnalysisService
    {
        return $this->technicalAnalysisService;
    }

    public function newsSentiment(): NewsSentimentService
    {
        return $this->newsSentimentService;
    }
}