<?php

namespace Mohanad\Autochartist\Facades;

use Illuminate\Support\Facades\Facade;

class Autochartist extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'autochartist';
    }
}
