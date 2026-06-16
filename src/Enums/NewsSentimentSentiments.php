<?php

namespace Asciisd\AutochartistLaravel\Enums;

enum NewsSentimentSentiments: string
{
    case Positive = 'Positive';
    case Negative = 'Negative';
    case Neutral = 'Neutral';
    case VeryPositive = 'Very Positive';
    case VeryNegative = 'Very Negative';


    public static function toArray(): array
    {
        return [
            self::Positive->value,
            self::Negative->value,
            self::Neutral->value,
            self::VeryPositive->value,
            self::VeryNegative->value,
        ];
    }

    public static function options(): array
    {
        return collect(self::toArray())->mapWithKeys(function ($item) {
            return [$item => ucwords($item)];
        })->toArray();
    }

}


