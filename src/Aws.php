<?php

namespace Spatie\LaravelMailcoachSesSetup;

use Aws\Result;
use Aws\SesV2\Exception\SesV2Exception;
use Aws\SesV2\SesV2Client;
use Aws\Sns\SnsClient;
use Illuminate\Support\Str;

class Aws
{
    protected SesV2Client $ses;

    protected SnsClient $sns;

    public function __construct(
        protected string $key,
        protected string $secret,
        protected string $region
    )
    {
        $this->ses = new SesV2Client([
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ],
            'region' => $region,
            'version' => '2019-09-27',
        ]);

        $this->sns = new SnsClient([
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ],
            'region' => $region,
            'version' => '2010-03-31',
        ]);
    }

    public function getAwsAccount(): Result
    {
        return $this->ses->getAccount();
    }

    public function configurationSetExists(string $name): bool
    {
        try {
            $this->ses->getConfigurationSet(['ConfigurationSetName' => $name]);
        } catch (SesV2Exception $exception) {
            return false;
        }

        return true;
    }

    public function createConfigurationSet(string $name)
    {
        $this->ses->createConfigurationSet([
            'ConfigurationSetName' => $name,
        ]);
    }

    public function createSnsTopic(string $name): string
    {
        $result = $this->sns->createTopic([
            'Name' => $name,
        ]);

        return $result->get('TopicArn');
    }

    public function getSnsTopicArn(string $name): ?string
    {
        $result = $this->sns->listTopics([
            'Name' => $name,
        ]);

        foreach($result->get('Topics') as $topic) {
            if (str_ends_with($topic['TopicArn'], ":{$name}", )) {
                return $topic['TopicArn'];
            }
        }

         return null;
    }

    public function createSnsSubscription(
        string $snsTopicArn,
        string $protocol,
        string $endpoint,
    )
    {
        $this->sns->subscribe([
            'TopicArn' => $snsTopicArn,
            'Protocol' => $protocol,
            'Endpoint' => $endpoint,
        ]);
    }

    public function createConfigurationSetEventDestination(string $configurationName, $snsDestinationTopicArn): self
    {
        $config = [
            'ConfigurationSetName' => $configurationName,
            'EventDestination' => [
                'Enabled' => true,
                'MatchingEventTypes' => ['REJECT', 'BOUNCE', 'COMPLAINT', 'OPEN', 'CLICK'],
                'SnsDestination' => [
                    'TopicArn' => $snsDestinationTopicArn,
                ],
            ],
            'EventDestinationName' => 'mailcoach',
        ];

        $this->ses->createConfigurationSetEventDestination($config);

        return $this;
    }
}
