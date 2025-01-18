<?php

namespace App\Services;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;

class AWSSecretsManagerService
{
    protected $client;

    public function __construct()
    {
        $this->client = new SecretsManagerClient([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION', 'eu-north-1'),
        ]);
    }

    public function getSecretValue($secretName)
    {
        try {
            $result = $this->client->getSecretValue([
                'SecretId' => $secretName,
            ]);

            if (isset($result['SecretString'])) {
                $secret = $result['SecretString'];
                return json_decode($secret, true);
            } else {
                Log::error('SecretBinary is not supported in this example.');
                return null;
            }
        } catch (AwsException $e) {
            // Handle error
            Log::error('Error retrieving secret: ' . $e->getMessage());
            return null;
        }
    }
}
