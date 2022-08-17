<?php

namespace App\Requests\Arrival;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class ArrivalFilterRequest implements Request
{

    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(!User::checkAuth()){
            Error::custom(401, 'Требуется авторизация.');
        }
        if(isset($request->equipment) and !is_array($request->equipment)){
            Error::errorRequest();
        }
		if(isset($request->user) and !is_array($request->user)){
            Error::errorRequest();
        }
        if(isset($request->category) and !is_array($request->category)){
            Error::errorRequest();
        }
        if(isset($request->arrival_start) and !is_string($request->arrival_start)){
            Error::errorRequest();
        }
        if(isset($request->arrival_end) and !is_string($request->arrival_end)){
            Error::errorRequest();
        }
        if(isset($request->count_start) and !is_int($request->count_start)){
            Error::errorRequest();
        }
        if(isset($request->count_end) and !is_int($request->count_end)){
            Error::errorRequest();
        }
    }
}