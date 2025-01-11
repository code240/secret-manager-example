<?php

namespace App\Http\Controllers;

use App\Services\SecretManagerService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request) {

        $secretManager = new SecretManagerService();
        $secrets = $secretManager->getSecret('MY_TEST_SECRET');

        $envType = $secrets['USER_KEY'] ?? 'none';

        return [
            'status' => true,
            'key_type' => $envType,
        ];
    }
}
