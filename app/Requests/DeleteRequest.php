<?php

namespace App\Requests;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class DeleteRequest implements Request
{

    /**
     * @param $request
     * @return void
     */
    public static function request($request)
    {
        if(!User::checkAuth()){
            Error::custom(401, 'Требуется авторизация.');
        }
        if(!is_object($request) or !is_numeric($request->id)){
            Error::errorRequest();
        }
    }
}