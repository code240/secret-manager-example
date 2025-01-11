<?php

namespace App\Services;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;

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

            if (isset($result['SecretString'])) {
                Log::info("Secret String retrieved...",[$result['SecretString']]);
                return json_decode($result['SecretString'], true); // Decode the secret JSON
            }
            Log::info("Secret String not retrieved...",[$result]);
            return null;


        } catch (AwsException $e) {
            // Handle errors (log or throw)
            Log::error("Error retrieving secret".$e->getMessage());
            return null;
        }
    }
}
