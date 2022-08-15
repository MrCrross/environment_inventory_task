<?php

namespace App\Services;

use App\Models\Arrival;

class ArrivalService
{
    /**
     * @return array|false|object|string|null
     */
    public static function get(object $request){
        $arrival = new Arrival();
        return $arrival->paginate($request,10);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public static function find(int $id){
        $arrival = new Arrival();
        return $arrival->find($id);
    }

    /**
     * @param object $request
     * @return void
     */
    public static function create(object $request){
        $arrival = new Arrival();
        $request->user_id=$_SESSION['user']->id;
        return $arrival->create((array)$request);
    }

    /**
     * @param object $request
     * @param int $id
     * @return void
     */
    public static function update(object $request,int $id){
        $arrival = new Arrival();
        unset($request->id);
        return $arrival->edit((array)$request,$id);
    }

    /**
     * @param int $id
     * @return void
     */
    public static function delete(int $id){
        $arrival = new Arrival();
        $arrival->remove($id);
    }
}