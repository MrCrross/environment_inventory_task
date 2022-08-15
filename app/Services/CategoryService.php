<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * @return array|false|object|string|null
     */
    public static function get(object $request){
        $category = new Category();
        return $category->paginate($request,10);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public static function find(int $id){
        $category = new Category();
        return $category->find($id);
    }

    /**
     * @param object $request
     * @return void
     */
    public static function create(object $request){
        $category = new Category();
        return $category->create((array)$request);
    }

    /**
     * @param object $request
     * @param int $id
     * @return void
     */
    public static function update(object $request,int $id){
        $category = new Category();
        unset($request->id);
        return $category->edit((array)$request,$id);
    }

    /**
     * @param int $id
     * @return void
     */
    public static function delete(int $id){
        $category = new Category();
        $category->remove($id);
    }
}