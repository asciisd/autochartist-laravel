<?php

namespace Asciisd\AutochartistLaravel\Services;

use Illuminate\Support\Facades\Http;
use Asciisd\AutochartistLaravel\Exceptions\AutochartistException;

class EconomicCalendar extends AbstractService
{

    protected string $base = 'https://eia.autochartist.com/calendar/';

    public function getEconomicCalendar(): string
    {
        $url = $this->client->buildUrl($this->base);
        $response = Http::get($url);

        if ($response->failed()) {
            throw AutochartistException::requestFailed($response->status(), $response->body());
        }

        return $url;
    }
}