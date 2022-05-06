<?php

namespace Spatie\LaravelMailcoachSesSetup\Exception;

use Aws\SesV2\Exception\SesV2Exception;
use Exception;
use Spatie\LaravelMailcoachSesSetup\SetupConfig;

class InvalidAwsCredentials extends Exception
{
    public static function make(SesV2Exception $exception, SetupConfig $config): self
    {
        $message = $exception->getAwsErrorMessage();

        if (empty($message) && str_contains($exception->message, 'Could not resolve host')) {
            $message = "You have specified an invalid region: {$config->region}.";
        };
        return new self($message, previous: $exception);
    }
}
