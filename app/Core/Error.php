<?php

namespace App\Core;

use App\Modules\JsonResponse;

class Error
{
    /**
     * @param string|int $status
     * @param string $message
     * @return void
     */
    public static function custom($status, string $message)
    {
        JsonResponse::response([
            'status' => $status,
            'message' => $message
        ]);
        exit();
    }

    /**
     * @param string $message
     * @return void
     */
    public static function errorRequest(string $message = 'Неверные данные.')
    {
        JsonResponse::response([
            'status' => 406,
            'message' => $message
        ]);
        exit();
    }
}