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
        if(isset($request->arrivalStart) and !is_string($request->arrivalStart)){
            Error::errorRequest();
        }
        if(isset($request->arrivalEnd) and !is_string($request->arrivalEnd)){
            Error::errorRequest();
        }
        if(isset($request->countStart) and !is_int($request->countStart)){
            Error::errorRequest();
        }
        if(isset($request->countEnd) and !is_int($request->countEnd)){
            Error::errorRequest();
        }
    }
}