<?php

namespace Asciisd\Autochartist\Services;

use Asciisd\Autochartist\Contracts\AutochartistClientInterface;
use Asciisd\Autochartist\DTOs\NewsSentiment\ExtremeScoreChangeRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\HistoryRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SectorsRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SentimentRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SignificantSentimentRequest;
use Asciisd\Autochartist\DTOs\NewsSentiment\SourcesRequest;
use Asciisd\Autochartist\Traits\HasAuthentication;

class NewsSentimentService
{
    use HasAuthentication;

    public function __construct(
        private readonly AutochartistClientInterface $client
    ) {}

    /**
     * Get latest sentiment data for tickers.
     * This endpoint uses filtering to search for the latest sentiment data.
     */
    public function getSentiment(?SentimentRequest $request = null): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        unset($query['account_type']);

        return $this->client->get($request->getPath(), $query);
    }

    /**
     * Get extreme score changes (changes by 30+ points).
     * An extreme score change is when the sentiment score changes by or more than 30 points.
     */
    public function getExtremeScoreChange(ExtremeScoreChangeRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        unset($query['account_type']);

        return $this->client->get($request->getPath(), $query);
    }

    /**
     * Get significant sentiments (sentiment reaches very positive or very negative).
     * A significant sentiment is when the overall sentiment changes to either very negative (< -60) or very positive (> 60).
     */
    public function getSignificantSentiment(SignificantSentimentRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        return $this->client->get($request->getPath(), $query);
    }

    /**
     * Get historical sentiment data for a specific ticker.
     */
    public function getHistory(HistoryRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        unset($query['account_type']);

        return $this->client->get($request->getPath(), $query);
    }

    /**
     * Get available sectors.
     * Returns a list of available sectors for filtering sentiment data.
     */
    public function getSectors(SectorsRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        unset($query['account_type']);

        return $this->client->get($request->getPath(), $query);
    }

    /**
     * Get available news sources.
     * Returns a list of available news sources used for sentiment analysis.
     */
    public function getSources(SourcesRequest $request): array
    {
        $query = array_merge(
            $this->getDefaultParams($request->expire),
            $request->toArray()
        );

        unset($query['account_type']);

        return $this->client->get($request->getPath(), $query);
    }
}