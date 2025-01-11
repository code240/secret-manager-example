<?php

namespace App\Services;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;

class SecretManagerService
{
    protected $client;

    public function __construct()
    {
        $this->client = new SecretsManagerClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    public function getSecret(string $secretName)
    {
        try {
            $result = $this->client->getSecretValue(['SecretId' => $secretName]);
            return isset($result['SecretString']) ? json_decode($result['SecretString'], true) : null;
        } catch (AwsException $e) {
            // Handle errors (log or throw)
            return null;
        }
    }
}
