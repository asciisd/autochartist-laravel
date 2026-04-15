<?php

namespace Mohanad\Autochartist\DTOs\TechnicalAnalysis;

class PatternDetailRequest
{
    public function __construct(
        public readonly string $type,
        public readonly string $uid,
        public readonly ?string $expire = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'expire' => $this->expire,
        ], fn ($value) => $value !== null);
    }

    /**
     * Get the endpoint path for this request.
     */
    public function getPath(): string
    {
        return "/to/resources/results/detail/{$this->type}/{$this->uid}";
    }
}