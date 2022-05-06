<?php

namespace Spatie\LaravelMailcoachSesSetup\Commands;

use Illuminate\Console\Command;
use Spatie\LaravelMailcoachSesSetup\Setup;
use Spatie\LaravelMailcoachSesSetup\SetupConfig;

class SetupCommand extends Command
{
    public $signature = 'mailcoach:setup-ses';

    public $description = 'Setup SES for use with Mailcoach';

    public function handle(): int
    {
        $key = 'akia5vdhx4duawp2he7i';
        $secret = '2nrgzpsvy7sthtbpwym6tjgmjfyjbrrwg5iofpb0';
        $region = 'eu-central-1';

        $config = new SetupConfig($key, $secret, $region);

        (new Setup($config))->start();

        return self::SUCCESS;
    }
}
