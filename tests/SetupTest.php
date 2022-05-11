<?php

use Spatie\LaravelMailcoachSesSetup\Setup;
use Spatie\LaravelMailcoachSesSetup\SetupConfig;

it('can configure an AWS account for use with Mailcoach', function () {
    $config = new SetupConfig(
        $this->key,
        $this->secret,
        $this->region,
        'https://spatie.be/ses-feedback',
    );

    (new Setup($config))->install();
});

it('can remove the Mailcoach configuration for an AWS account', function () {
    $config = new SetupConfig(
        $this->key,
        $this->secret,
        $this->region
    );

    (new Setup($config))->uninstall();
});
