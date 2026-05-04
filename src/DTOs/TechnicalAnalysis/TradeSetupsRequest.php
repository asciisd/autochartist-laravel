<?php

declare(strict_types=1);

namespace Asciisd\Autochartist\DTOs\TechnicalAnalysis;

use Asciisd\Autochartist\DTOs\BaseDTO;

/**
 * Trade Setups Request DTO
 *
 * Fetches technical analysis trade setups including:
 * - Chart patterns
 * - Fibonacci retracements
 * - Key support/resistance levels
 */
readonly class TradeSetupsRequest extends BaseDTO
{
    public function __construct(
        public ?string $timezone = null,
        public ?string $locale = null,
        public ?string $locales = null,
        public ?string $group = null,
        public ?bool $includeDetail = null,
        public ?bool $includeDrawing = null,
        public ?int $pageLimit = null,
        public ?int $pageOffset = null,
        public ?string $since = null,
    ) {}

    public function toArray(): array
    {
        return $this->toSnakeCaseArray();
    }
}