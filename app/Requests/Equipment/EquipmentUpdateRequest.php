<?php

namespace App\Requests\Equipment;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class EquipmentUpdateRequest implements Request
{

    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(!User::checkAuth()){
            Error::custom(401, 'Требуется авторизация.');
        }
        if(!is_object($request)){
            Error::errorRequest();
        }
        if(isset($request->name) and !is_string($request->name)){
            Error::errorRequest();
        }
        if(!isset($request->id) or !is_int($request->id)){
            Error::errorRequest();
        }
        if (isset($request->price) and !is_int($request->price)) {
            Error::errorRequest();
        }
        if (isset($request->category_id) and (!is_int($request->category_id) or $request->category_id < 1)) {
            Error::errorRequest();
        }
    }
}