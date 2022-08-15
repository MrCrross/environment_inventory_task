<?php

namespace App\Controllers\Auth;

use App\Modules\JsonResponse;
use App\Requests\Auth\RegistrationRequest;
use App\Services\UserService;

class RegistrationController
{
    /**
     * @param object $request
     * @return void
     */
    public function registration(object $request){
        RegistrationRequest::request($request);
        JsonResponse::response([
            'data'=>UserService::registration($request)
        ]);
    }

}