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
            'include_detail' => 'true ',
        ], $query);

        // Normalize boolean-like flags to the 'true'/'false' strings the API expects.
        foreach (['strong_sentiment', 'include_detail'] as $flag) {
            $query[$flag] = filter_var($query[$flag], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
        }

        $sectors = [];
        foreach ($this->getSectors() as $item) {
            $sectors[$item] = str_replace(' ', '_', ucwords($item));
        }

        return [
            'sectors' => $sectors,
            'sentiments' => NewsSentimentSentiments::options(),
            'data' => $this->client->get('newssentiment/sentiment', $query),
        ];
    }

    /**
     * Get extreme score change.
     *
     * @param array<string, mixed> $query
     * @return array<mixed>
     */
    public function getExtremeScoreChange(array $query = []): array
    {
        if (empty($query['date_input'])) {
            $query['date_input'] = date('Y-m-d');
        }

        return [
            'data' => $this->client->get("newssentiment/extreme_score_change", $query),
        ];
    }

    /**
     * Get news sentiment details.
     *
     * @param array<string, mixed> $query
     * @return array<mixed>
     */
    public function getSignificantSentiment(array $query = []): array
    {
        
        if (empty($query['date_input'])) {
            $query['date_input'] = date('Y-m-d');
        }

        return [
            'data' => $this->client->get("newssentiment/significant_sentiment", $query),
        ];
    }

    public function getHistory(string $ticker ,array $query = []): array
    {
        if (empty($ticker)) {
            throw new \InvalidArgumentException('Ticker is required');
        }

        // Default values, only applied when the user did not supply them.
        $query = array_merge([
            'days_back' => 5,
            'ticker' => $ticker,
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