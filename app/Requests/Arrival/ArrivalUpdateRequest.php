<?php

namespace App\Requests\Arrival;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class ArrivalUpdateRequest implements Request
{

    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(!User::checkAuth()){
            Error::custom(401, 'Требуется авторизация.');
        }
        if(!isset($request->id) or !is_int($request->id)){
            Error::errorRequest();
        }
        if(isset($request->environment_id) and !is_int($request->environment_id)){
            Error::errorRequest();
        }
        if(isset($request->count) and !is_int($request->count)){
            Error::errorRequest();
        }
        if(isset($request->arrival) and !is_string($request->arrival)){
            Error::errorRequest();
        }
    }
}