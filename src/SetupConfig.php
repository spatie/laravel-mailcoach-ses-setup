<?php

namespace Spatie\LaravelMailcoachSesSetup;

class SetupConfig
{
    public string $sesConfigurationName = 'mailcoach';

    public string $snsTopicName = 'mailcoach';

    public string $snsSubscriptionProtocol = 'https';
    public string $snsSubscriptionEndpoint = 'https://mailcoach.app/ses-feedback';

    public function __construct(
        public string $key,
        public string $secret,
        public string $region
    ) {
    }

    public function setSesConfigurationName(string $name): self
    {
        $this->sesConfigurationName = $name;

        return $this;
    }
}
