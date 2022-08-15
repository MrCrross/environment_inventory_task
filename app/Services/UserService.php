<?php

namespace App\Services;

use App\Core\Error;
use App\Models\User;

class UserService
{
    /**
     * @param object|array $request
     * @return array|void
     */
    public static function login($request): array
    {
        $user = new User();
        if ($user->check($request->name, hash('sha256', $request->password))) {
            return ["name" => $request->name];
        }
        Error::custom('401', 'Неверный логин или пароль.');
    }

    /**
     * @param $request
     * @return array
     */
    public static function registration($request): array
    {
        $user = new User();
        $user->registration($request->name, hash('sha256', $request->password));
        return ["name" => $request->name];
    }

    /**
     * @return array|false|object|string|null
     */
    public static function get(object $request)
    {
        $user = new User();
        return $user->paginate($request, 10);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public static function find(int $id)
    {
        $user = new User();
        return $user->find($id);
    }

    /**
     * @param object $request
     * @return void
     */
    public static function create(object $request)
    {
        $user = new User();
        $request->password = hash('sha256', $request->password);
        return $user->create((array)$request);
    }

    /**
     * @param object $request
     * @param int $id
     * @return void
     */
    public static function update(object $request, int $id)
    {
        $user = new User();
        unset($request->id);
        if (isset($request->password) and strlen($request->password)!=0) {
            $request->password = hash('sha256', $request->password);
        }
        return $user->edit((array)$request, $id);
    }

    /**
     * @param int $id
     * @return void
     */
    public static function delete(int $id)
    {
        $user = new User();
        $user->remove($id);
    }
}