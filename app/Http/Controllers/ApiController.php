<?php

namespace App\Http\Controllers;

use App\Services\SecretManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function index(Request $request) {

        Log::info("Index function initialized");
        $secretManager = new SecretManagerService();
        $secrets = $secretManager->getSecret('MY_TEST_SECRET');
        Log::info("SecretManager response:",[$secrets]);
        $envType = $secrets['USER_KEY'] ?? 'none';

        return [
            'status' => true,
            'key_type' => $envType,
        ];
    }
}
