<?php

namespace App\Requests\User;

use App\Core\Error;
use App\Models\User;
use App\Modules\Interfaces\Request;

class UserCreateRequest implements Request
{

    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(!User::checkAuth()){
            Error::custom(401, 'Требуется авторизация.');
        }
        if(!isset($request->name) or !is_string($request->name)){
            Error::errorRequest();
        }
        if(!isset($request->password) or !is_string($request->password) or strlen($request->password)<8){
            Error::errorRequest('Неверный или короткий пароль.');
        }
    }
}