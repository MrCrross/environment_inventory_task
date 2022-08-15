<?php

namespace App\Modules\Interfaces;

interface Request
{
    /**
     * @param object|array $request
     * @return mixed
     */
    public static function request($request);
}