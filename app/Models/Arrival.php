<?php

namespace App\Models;

use App\Core\Error;
use App\Core\Model;
use PDOException;

class Arrival extends Model
{
    protected string $table='arrival';
    protected bool $deleted_at = true;

    /**
     * @param object $request
     * @param int $count
     * @return array|false|object|string|null
     */
    public function paginate(object $request,int $count){
        $arrival=self::setSelect([
            'e.id e_id',
            'e.name e_name',
            'e.price e_price',
            'c.id c_id',
            'c.name c_name',
            'u.name u_name',
            'arrival.count a_count',
            'arrival.arrival a_arrival'])
            ->join('environments as e', 'e.id', '=', 'arrival.environment_id')
            ->join('users as u', 'u.id', '=', 'arrival.user_id')
            ->join('categories as c', 'e.category_id', '=', 'c.id');
        if(isset($request->environment)){
            $arrival=$arrival->whereIn('e.id',$request->environment);
        }
        if(isset($request->category)){
            $arrival=$arrival->whereIn('c.id',$request->category);
        }
        if(isset($request->arrivalStart)){
            $arrival=$arrival->where('arrival.arrival','>=',"{$request->arrivalStart}");
        }
        if(isset($request->arrivalEnd)){
            $arrival=$arrival->where('arrival.arrival','<=',"{$request->arrivalEnd}");
        }
        if(isset($request->countStart)){
            $arrival=$arrival->where('arrival.count','>=',"{$request->countStart}");
        }
        if(isset($request->countEnd)){
            $arrival=$arrival->where('arrival.count','<=',"{$request->countEnd}");
        }
        if(isset($request->orderBy) and isset($request->sort)){
            $arrival=$arrival->orderBy($request->orderBy,$request->sort);
        }
        return $arrival->pagination($count);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public function find(int $id){
        return self::setSelect([
            'e.id e_id',
            'e.name e_name',
            'e.price e_price',
            'c.id c_id',
            'c.name c_name',
            'u.name u_name',
            'arrival.count a_count',
            'arrival.arrival a_arrival'])
            ->join('environments as e', 'e.id', '=', 'arrival.environment_id')
            ->join('users as u', 'u.id', '=', 'arrival.user_id')
            ->join('categories as c', 'e.category_id', '=', 'c.id')
            ->where('arrival.id','=',$id)->select();
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