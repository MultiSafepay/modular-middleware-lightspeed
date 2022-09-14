<?php

namespace ModularLightspeed\ModularLightspeed\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ModularLightspeed\ModularLightspeed\ModularLightspeed
 */
class ModularLightspeed extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ModularLightspeed\ModularLightspeed\ModularLightspeed::class;
    }
}
