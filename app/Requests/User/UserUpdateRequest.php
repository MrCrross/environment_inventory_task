<?php

namespace App\Requests\User;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class UserUpdateRequest implements Request
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
        if(!is_object($request) or !is_string($request->name) or !is_string($request->password) or !is_int($request->id)){
            Error::errorRequest();
        }
    }
}