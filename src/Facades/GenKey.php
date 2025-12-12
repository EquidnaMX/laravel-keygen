<?php

namespace Ometra\Genkey\Facades;

use Illuminate\Support\Facades\Facade;

class GenKey extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Ometra\Genkey\Genkey::class;
    }
}
