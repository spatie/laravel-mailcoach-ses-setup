<?php

namespace Spatie\LaravelMailcoachSesSetup\Commands;

use Illuminate\Console\Command;

class LaravelMailcoachSesSetupCommand extends Command
{
    public $signature = 'laravel-mailcoach-ses-setup';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
