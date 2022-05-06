<?php

namespace Spatie\LaravelMailcoachSesSetup\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\LaravelMailcoachSesSetup\LaravelMailcoachSesSetup
 */
class LaravelMailcoachSesSetup extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-mailcoach-ses-setup';
    }
}
