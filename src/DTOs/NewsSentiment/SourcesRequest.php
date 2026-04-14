<?php

namespace Mohanad\Autochartist\DTOs\NewsSentiment;

class SourcesRequest
{
    public function toArray(): array
    {
        return [];
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return '/newssentiment/sources';
    }
}
