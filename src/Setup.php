<?php

namespace Spatie\LaravelMailcoachSesSetup;

use Aws\SesV2\Exception\SesV2Exception;
use Spatie\LaravelMailcoachSesSetup\Events\ConfigurationSetCreatedEvent;
use Spatie\LaravelMailcoachSesSetup\Events\CredentialsValidatedEvent;
use Spatie\LaravelMailcoachSesSetup\Exception\ConfigurationSetAlreadyExists;
use Spatie\LaravelMailcoachSesSetup\Exception\InvalidAwsCredentials;

class Setup
{
    protected Aws $aws;

    protected SetupConfig $config;

    public function __construct(SetupConfig $setupConfig)
    {
        $this->aws = new Aws($setupConfig->key, $setupConfig->secret, $setupConfig->region);

        $this->config = $setupConfig;
    }

    public function install()
    {
            $this
                ->ensureValidAwsCredentials()
                ->ensureConfigurationSetDoesNotExistYet()
                ->createConfigurationSet()
                ->createSnsTopic()
                ->createSnsSubscription()
                ->addSnsSubscriptionToSesTopic()
                ->createSesIdentity();

            return $this;
    }

    public function verify(): self
    {
        $this
            ->ensureValidAwsCredentials();

        return $this;
    }

    public function uninstall(): self
    {
        $this
            ->ensureValidAwsCredentials()
            ->deleteConfigurationSet()
            ->deleteSnsTopic();

        return $this;
    }

    protected function ensureValidAwsCredentials(): self
    {
        try {
            $this->aws->getAwsAccount();
        } catch (SesV2Exception $exception) {
            throw InvalidAwsCredentials::make($exception, $this->config);
        }

        return $this;
    }

    protected function ensureConfigurationSetDoesNotExistYet(): self
    {
        if($this->aws->configurationSetExists($this->config->sesConfigurationName)) {
            throw ConfigurationSetAlreadyExists::make($this->config->sesConfigurationName);
        }

        return $this;
    }

    protected function createConfigurationSet(): self
    {
        $this->aws->createConfigurationSet($this->config->sesConfigurationName);

        return $this;
    }

    protected function createSnsTopic(): self
    {
        $this->aws->createSnsTopic($this->config->snsTopicName);

        return $this;
    }

    protected function createSnsSubscription(): self
    {
        $arn = $this->aws->getSnsTopicArn($this->config->snsTopicName);

        $this->aws->createSnsSubscription(
            $arn,
            $this->config->snsSubscriptionProtocol,
            $this->config->snsSubscriptionEndpoint,
            $this->config->maxWebhookReceivesPerSecond,
        );

        return $this;
    }

    protected function addSnsSubscriptionToSesTopic(): self
    {
        $arn = $this->aws->getSnsTopicArn($this->config->snsTopicName);

        $this->aws->createConfigurationSetEventDestination($this->config->sesConfigurationName, $arn);

        return $this;
    }

    protected function createSesIdentity(): self
    {
        if (! $email = $this->config->sesIdentifyEmail) {
            return $this;
        }

        $this->aws->addSesIdentity($email);

        return $this;
    }

    protected function deleteConfigurationSet(): self
    {
        $this->aws->deleteConfigurationSet($this->config->sesConfigurationName);

        return $this;
    }

    protected function deleteSnsTopic(): self
    {
        $this->aws->deleteSnsTopic($this->config->snsTopicName);

        return $this;
    }
}
