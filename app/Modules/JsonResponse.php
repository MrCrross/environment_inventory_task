<?php

namespace App\Modules;

use App\Modules\Interfaces\Response;

class JsonResponse implements Response
{
    /**
     * @param $data
     * @return void
     */
    public static function response($data)
    {
        header('Content-type: application/json');
        echo json_encode($data);
    }
}