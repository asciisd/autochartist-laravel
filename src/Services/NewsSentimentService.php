<?php

namespace Asciisd\AutochartistLaravel\Services;

use Asciisd\AutochartistLaravel\Enums\NewsSentimentSentiments;

class NewsSentimentService extends AbstractService
{


    /**
     * Get news sentiment.
     *
     * @param array<string, mixed> $query
     * @return array<mixed>
     */
    public function getSentiment(array $query = []): array
    {

        // Default values, only applied when the user did not supply them.
        $query = array_merge([
            'strong_sentiment' => 'false',
            'include_details' => 'false',
        ], $query);

        // Normalize boolean-like flags to the 'true'/'false' strings the API expects.
        foreach (['strong_sentiment', 'include_details'] as $flag) {
            $query[$flag] = filter_var($query[$flag], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
        }

        $sectors = collect($this->getSectors())->mapWithKeys(function ($item) {
            return [$item => str_replace(' ', '_', ucwords($item['name']))];
        })->toArray();

        return response()->json(
            [
                'sectors' => $sectors,
                'sentiments' => NewsSentimentSentiments::options(),
                'data' => $this->client->get('newssentiment/sentiment', $query),
            ],
            200
        );
    }

    /**
     * Get extreme score change.
     *
     * @param array<string, mixed> $query
     * @return array<mixed>
     */
    public function getExtremeScoreChange(array $query = []): array
    {
        if (!empty($query['date_input'])) {
            $query['date_input'] = now()->format('Y-m-d');
        }
        
        return response()->json(
            [
                'data' => $this->client->get("newssentiment/extremescorechange", $query),
            ],
            200
        );
    }

    /**
     * Get news sentiment details.
     *
     * @param array<string, mixed> $query
     * @return array<mixed>
     */
    public function getSignificantSentiment(array $query = []): array
    {
        
        if (!empty($query['date_input'])) {
            $query['date_input'] = now()->format('Y-m-d');
        }
        
        return response()->json(
            [
                'data' => $this->client->get("newssentiment/significant_sentiment", $query),
            ],
            200
        );
    }

    public function getHistory(array $query = []): array
    {

        // Default values, only applied when the user did not supply them.
        $query = array_merge([
            'days_back' => 5,
            'ticker' => 'AAPL',
        ], $query);

        return $this->client->get("newssentiment/history", $query);
    }

    public function getSectors(): array
    {
        return $this->client->get("newssentiment/sectors");
    }

    public function getSources(): array
    {
        return $this->client->get("newssentiment/sources");
    }


}