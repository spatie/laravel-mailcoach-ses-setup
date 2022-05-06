<?php

use Spatie\LaravelMailcoachSesSetup\Setup;
use Spatie\LaravelMailcoachSesSetup\SetupConfig;

it('can test', function () {
    $key = env('AWS_ACCESS_KEY_ID');
    $secret = env('AWS_SECRET_ACCESS_KEY');
    $region = env('AWS_DEFAULT_REGION');

    $config = new SetupConfig($key, $secret, $region);

    (new Setup($config))->install();
});
