<?php

namespace App\Requests\Environment;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class EnvironmentCreateRequest implements Request
{

    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(!User::checkAuth()){
            Error::custom(401, 'Требуется авторизация.');
        }
        $request=(array)$request;
        if(count($request)===0){
            Error::errorRequest();
        }
        foreach ($request as $value) {
            if (!isset($value->name) or !is_string($value->name)) {
                Error::errorRequest();
            }
            if (!isset($value->price) or !is_int($value->price)) {
                Error::errorRequest();
            }
            if (!isset($value->category_id) or !is_int($value->category_id) or $value->category_id < 1) {
                Error::errorRequest();
            }
        }
    }
}