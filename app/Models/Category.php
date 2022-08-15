<?php

namespace App\Models;

use App\Core\Error;
use App\Core\Model;
use PDOException;

class Category extends Model
{
    protected string $table='categories';

    /**
     * @param object $request
     * @param int $count
     * @return array|false|object|string|null
     */
    public function paginate(object $request,int $count){
        $categories=new Category();
        if(isset($request->name)){
            $categories=$categories->where('name','LIKE',"%{$request->name}%");
        }
        if(isset($request->orderBy) and isset($request->sort)){
            $categories=$categories->orderBy($request->orderBy,$request->sort);
        }
        return $categories->pagination($count);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public function find(int $id){
        return self::where('id','=',$id)->select();
    }

    /**
     * @param array $request
     * @return false|string|void
     */
    public function create(array $request){
        try{
            $this->connect->beginTransaction();
            $result = self::insert($request);
            $this->connect->commit();
            return $result;
        }catch (PDOException $e){
            $this->connect->rollBack();
            Error::custom($e->getCode(),$e->getMessage());
        }
    }

    /**
     * @param array $request
     * @param int $id
     * @return false|string|void
     */
    public function edit(array $request,int $id){
        try{
            $this->connect->beginTransaction();
            $result = self::where('id','=',$id)->update($request);
            $this->connect->commit();
            return $result;
        }catch(PDOException $e){
            $this->connect->rollBack();
            Error::custom($e->getCode(),$e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function remove(int $id){
        try{
            $this->connect->beginTransaction();
            self::where('id','=',$id)->delete();
            $this->connect->commit();
        }catch(PDOException $e){
            $this->connect->rollBack();
            Error::custom($e->getCode(),$e->getMessage());
        }
    }
}