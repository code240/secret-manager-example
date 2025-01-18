<?php

namespace App\Http\Controllers;

use App\Services\AWSSecretsManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function index(Request $request) {

        Log::info("Index function initialized");
        $secretManager = new AWSSecretsManagerService();
        $secrets = $secretManager->getSecretValue('MY_TEST_SECRET');
        Log::info("SecretManager response:",[$secrets]);
        $envType = $secrets['USER_KEY'] ?? 'none';
        return [
            'status' => true,
            'key_type' => $envType,
        ];
    }
}
