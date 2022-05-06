<?php

namespace Spatie\LaravelMailcoachSesSetup\Tests;

use Dotenv\Dotenv;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelMailcoachSesSetup\SesSetupServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadEnvironmentVariables();
    }

    protected function getPackageProviders($app)
    {
        return [
            SesSetupServiceProvider::class,
        ];
    }

    protected function loadEnvironmentVariables()
    {
        if (!file_exists(__DIR__ . '/../.env')) {
            return;
        }

        $dotEnv = Dotenv::createImmutable(__DIR__ . '/..');

        $dotEnv->load();
    }
}
