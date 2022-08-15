<?php

namespace App\Requests\User;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class UserFilterRequest implements Request
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
        if(isset($request->name) and !is_string($request->name)){
            Error::errorRequest();
        }
        if(isset($request->orderBy) and !is_string($request->orderBy)){
            Error::errorRequest();
        }
        if(isset($request->sort) and !is_string($request->sort)){
            Error::errorRequest();
        }
    }
}