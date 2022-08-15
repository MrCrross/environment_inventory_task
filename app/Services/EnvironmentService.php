<?php

namespace App\Services;


use App\Models\Environment;

class EnvironmentService
{
    /**
     * @return array|false|object|string|null
     */
    public static function get(object $request)
    {
        $environment = new Environment();
        return $environment->paginate($request,10);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public static function find(int $id)
    {
        $environment = new Environment();
        return $environment->find($id);
    }

    /**
     * @param object $request
     * @return void
     */
    public static function create(object $request)
    {
        $environment = new Environment();
        return $environment->create((array)$request);
    }

    /**
     * @param object $request
     * @param int $id
     * @return void
     */
    public static function update(object $request, int $id)
    {
        $environment = new Environment();
        unset($request->id);
        return $environment->edit((array)$request, $id);
    }

    /**
     * @param int $id
     * @return void
     */
    public static function delete(int $id)
    {
        $environment = new Environment();
        return $environment->remove($id);
    }
}