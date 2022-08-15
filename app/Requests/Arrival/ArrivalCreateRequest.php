<?php

namespace App\Requests\Arrival;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class ArrivalCreateRequest implements Request
{
    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(!User::checkAuth()){
            Error::custom(401, 'Требуется авторизация.');
        }
        if(!isset($request->equipment_id) or !is_int($request->equipment_id)){
            Error::errorRequest();
        }
        if(!isset($request->count) or !is_int($request->count)){
            Error::errorRequest();
        }
        if(!isset($request->arrival) or !is_string($request->arrival)){
            Error::errorRequest();
        }
    }
}