<?php

namespace Spatie\LaravelMailcoachSesSetup;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelMailcoachSesSetup\Commands\LaravelMailcoachSesSetupCommand;

class LaravelMailcoachSesSetupServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-mailcoach-ses-setup')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-mailcoach-ses-setup_table')
            ->hasCommand(LaravelMailcoachSesSetupCommand::class);
    }
}
