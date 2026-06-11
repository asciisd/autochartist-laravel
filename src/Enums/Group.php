<?php

namespace Asciisd\AutochartistLaravel\Enums;

enum Group: string
{
    case Commodities = 'Commodities';
    case Currencies = 'Currencies';
    case Stocks = 'Stocks';
    case Indices = 'Indices';

    public static function toArray(): array
    {
        return [
            self::Commodities->value,
            self::Currencies->value,
            self::Stocks->value,
            self::Indices->value,
        ];
    }

    public static function options(): array
    {
        return collect(self::toArray())->mapWithKeys(function ($item) {
            return [$item => ucwords($item)];
        })->toArray();
    }
}