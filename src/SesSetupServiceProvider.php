<?php

namespace Spatie\LaravelMailcoachSesSetup;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelMailcoachSesSetup\Commands\LaravelMailcoachSesSetupCommand;

class SesSetupServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-mailcoach-ses-setup')
            ->hasMigration('create_laravel-mailcoach-ses-setup_table');
    }
}
