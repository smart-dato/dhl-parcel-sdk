<?php

namespace SmartDato\DhlParcel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SmartDato\DhlParcel\DhlParcel
 */
class DhlParcel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SmartDato\DhlParcel\DhlParcel::class;
    }
}
