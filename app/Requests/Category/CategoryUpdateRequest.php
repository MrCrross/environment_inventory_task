<?php

namespace App\Requests\Category;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class CategoryUpdateRequest implements Request
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
        if(!is_object($request) or !is_string($request->name) or !is_int($request->id)){
            Error::errorRequest();
        }
    }
}