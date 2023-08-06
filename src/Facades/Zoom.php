<?php

namespace Bikare\LaravelZoom\Facades;

use Illuminate\Support\Facades\Facade;


class Zoom extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'zoom';
    }
}
