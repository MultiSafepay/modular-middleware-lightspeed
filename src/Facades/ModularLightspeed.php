<?php

namespace Modularlightspeed\Modularlightspeed\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Modularlightspeed\Modularlightspeed\Modularlightspeed
 */
class Modularlightspeed extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Modularlightspeed\Modularlightspeed\Modularlightspeed::class;
    }
}
