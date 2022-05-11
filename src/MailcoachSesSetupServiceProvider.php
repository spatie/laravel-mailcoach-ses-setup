<?php

namespace Spatie\LaravelMailcoachSesSetup;

use Spatie\LaravelMailcoachSesSetup\Commands\InstallCommand;
use Spatie\LaravelMailcoachSesSetup\Commands\UninstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MailcoachSesSetupServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-mailcoach-ses-setup')
            ->hasCommands(
                InstallCommand::class,
                UninstallCommand::class,
            );
    }
}
