<?php

namespace Mohanad\Autochartist\DTOs\TechnicalAnalysis;

class TradeSetupsRequest
{
    public function __construct(
        public readonly ?string $timezone = null,
        public readonly ?string $locale = null,
        public readonly ?string $locales = null,
        public readonly ?string $brokerId = null,
        public readonly ?string $group = null,
        public readonly ?bool $includeDetail = null,
        public readonly ?bool $includeDrawing = null,
        public readonly ?int $pageLimit = null,
        public readonly ?int $pageOffset = null,
        public readonly ?string $since = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'locales' => $this->locales,
            'broker_id' => $this->brokerId,
            'group' => $this->group,
            'include_detail' => $this->includeDetail,
            'include_drawing' => $this->includeDrawing,
            'page_limit' => $this->pageLimit,
            'page_offset' => $this->pageOffset,
            'since' => $this->since,
        ], fn ($value) => $value !== null);
    }
}
