<?php

namespace App\Services;

use Aws\SecretsManager\SecretsManagerClient;

class SecretManagerService
{
    protected $client;

    public function __construct()
    {
        $this->client = new SecretsManagerClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
        ]);
    }

    public function getSecret($secretName)
    {
        try {
            $result = $this->client->getSecretValue([
                'SecretId' => $secretName,
            ]);

            return json_decode($result['SecretString'], true);
        } catch (\Exception $e) {
            // Handle error
            return "";
        }
    }
}
