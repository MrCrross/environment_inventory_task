<?php

namespace App\Requests\Category;

use App\Core\Error;
use App\Modules\Interfaces\Request;

class CategoryFilterRequest implements Request
{

    /**
     * @inheritDoc
     */
    public static function request($request)
    {
        if(isset($request->name) and !is_string($request->name)){
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