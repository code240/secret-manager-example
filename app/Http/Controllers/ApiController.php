<?php

namespace App\Http\Controllers;

use App\Services\SecretManagerService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function index(Request $request) {

        $envType = env('USER_KEY','none');
        $servicemanager =  new SecretManagerService();
        $secrets = $servicemanager->getSecret(env('SECRET_NAME'));

        dd($secrets);

        return [
            'status' => true,
            'key_type' => $envType,
        ];
    }
}
