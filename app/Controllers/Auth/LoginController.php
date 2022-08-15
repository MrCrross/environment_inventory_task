<?php

namespace App\Controllers\Auth;

use App\Modules\JsonResponse;
use App\Requests\Auth\LoginRequest;
use App\Services\UserService;

class LoginController
{

    public function login(object $request)
    {
        LoginRequest::request($request);
        JsonResponse::response([
            'data'=>UserService::login($request)
        ]);
    }

    public function logout()
    {
        session_destroy();
        session_start();
    }
}