<?php

namespace App\Requests\Auth;

use App\Core\Error;
use App\Modules\Interfaces\Request;

class LoginRequest implements Request
{
    /**
     * @param object $request
     * @return void
     */
    public static function request($request)
    {
        if (!isset($request->name) or !is_string($request->name) or strlen($request->name) === 0) {
           Error::errorRequest('Логин пустой.');
        }
        if (!isset($request->password) or !is_string($request->password) or strlen($request->password) <= 8) {
            Error::errorRequest('Пароль не соответствует уровню безопасности.');
        }
        if (!isset($request->confirm_password) or !is_string($request->confirm_password) or $request->confirm_password !== $request->password) {
            Error::errorRequest('Пароли не совпадают.');
        }
    }
}