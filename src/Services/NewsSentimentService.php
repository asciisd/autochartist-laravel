<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\Services;

use Asciisd\Autochartist\DTOs\NewsSentiment\ExtremeScoreChangeRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\HistoryRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SectorsRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SentimentRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SignificantSentimentRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SourcesRequest;

/**
 * News Sentiment Service
 *
 * Provides sentiment analysis data from multiple news sources.
 */
final class NewsSentimentService extends BaseService
{
    /**
     * Get latest sentiment data for tickers.
     */
    public function getSentiment(?SentimentRequest $request = null): array
    {
        $request = $request ?? new SentimentRequest();
        $query = $this->buildQuery($request, includeAccountType: false);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get extreme score changes (changes by 30+ points).
     */
    public function getExtremeScoreChange(ExtremeScoreChangeRequest $request): array
    {
        $query = $this->buildQuery($request, includeAccountType: false);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get significant sentiments (sentiment reaches very positive or very negative).
     */
    public function getSignificantSentiment(SignificantSentimentRequest $request): array
    {
        $query = $this->buildQuery($request);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get historical sentiment data for a specific ticker.
     */
    public function getHistory(HistoryRequest $request): array
    {
        $query = $this->buildQuery($request, includeAccountType: false);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get available sectors.
     */
    public function getSectors(): array
    {
        $request = new SectorsRequest();
        $query = $this->buildQuery($request, includeAccountType: false);

        return $this->get($request->getPath(), $query);
    }

    /**
     * Get available news sources.
     */
    public function getSources(): array
    {
        $request = new SourcesRequest();
        $query = $this->buildQuery($request, includeAccountType: false);

        return $this->get($request->getPath(), $query);
    }
}