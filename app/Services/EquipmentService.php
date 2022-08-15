<?php

namespace App\Services;


use App\Models\Equipment;

class EquipmentService
{
    /**
     * @return array|false|object|string|null
     */
    public static function get(object $request)
    {
        $equipment = new Equipment();
        return $equipment->paginate($request,10);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public static function find(int $id)
    {
        $equipment = new Equipment();
        return $equipment->find($id);
    }

    /**
     * @param object $request
     * @return void
     */
    public static function create(object $request)
    {
        $equipment = new Equipment();
        return $equipment->create((array)$request);
    }

    /**
     * @param object $request
     * @param int $id
     * @return void
     */
    public static function update(object $request, int $id)
    {
        $equipment = new Equipment();
        unset($request->id);
        return $equipment->edit((array)$request, $id);
    }

    /**
     * @param int $id
     * @return void
     */
    public static function delete(int $id)
    {
        $equipment = new Equipment();
        $equipment->remove($id);
    }
}