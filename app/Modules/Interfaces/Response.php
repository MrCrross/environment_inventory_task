<?php

namespace App\Modules\Interfaces;

interface Response
{
    /**
     * @param string|object|array $data
     * @return mixed
     */
    public static function response($data);
}