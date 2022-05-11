<?php

use Spatie\LaravelMailcoachSesSetup\MailcoachSes;
use Spatie\LaravelMailcoachSesSetup\MailcoachSesConfig;

it('can configure an AWS account for use with Mailcoach', function () {
    $config = new MailcoachSesConfig(
        $this->key,
        $this->secret,
        $this->region,
        'https://spatie.be/ses-feedback',
    );

    (new MailcoachSes($config))->install();
});

it('can remove the Mailcoach configuration for an AWS account', function () {

    $config = new MailcoachSesConfig(
        $this->key,
        $this->secret,
        $this->region
    );

    (new MailcoachSes($config))->uninstall();
});
