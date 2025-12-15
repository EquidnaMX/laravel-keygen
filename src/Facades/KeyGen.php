<?php

namespace Equidna\KeyGen\Facades;

use Illuminate\Support\Facades\Facade;

class KeyGen extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Equidna\KeyGen\KeyGen::class;
    }
}
