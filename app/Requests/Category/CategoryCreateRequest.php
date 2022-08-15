<?php

namespace App\Requests\Category;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class CategoryCreateRequest implements Request
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
        $request=(array)$request;
        if(count($request)==0){
            Error::errorRequest();
        }
        foreach ($request as $value){
            if(!isset($value->name) or !is_string($value->name)){
                Error::errorRequest();
            }
        }
    }
}