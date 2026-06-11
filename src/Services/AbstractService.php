<?php

namespace Asciisd\AutochartistLaravel\Services;

abstract class AbstractService
{
    public function __construct(protected AutochartistClient $client)
    {
    }
}
