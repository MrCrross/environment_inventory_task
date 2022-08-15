<?php

namespace App\Requests\Equipment;

use App\Core\Error;
use App\Modules\Interfaces\Request;

class EquipmentFilterRequest implements Request
{

    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(isset($request->name) and !is_string($request->name)){
            Error::errorRequest();
        }
        if(isset($request->price) and !is_int($request->price)){
            Error::errorRequest();
        }
        if(isset($request->categories) and !is_array($request->categories)){
            Error::errorRequest();
        }
        if(isset($request->categories) and (!isset($request->categories[0]) or !is_int($request->categories[0]))){
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