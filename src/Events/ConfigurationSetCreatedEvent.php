<?php

namespace Spatie\LaravelMailcoachSesSetup\Events;

class ConfigurationSetCreatedEvent
{
    public function __construct(public string $name)
    {
    }
}
