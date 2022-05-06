<?php

namespace Spatie\LaravelMailcoachSesSetup;

use Spatie\LaravelMailcoachSesSetup\Commands\LaravelMailcoachSesSetupCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SesSetupServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-mailcoach-ses-setup')
            ->hasMigration('create_laravel-mailcoach-ses-setup_table');
    }
}
