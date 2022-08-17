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
            'u.id u_id',
            'u.name u_name',
            'arrival.count a_count',
            'arrival.arrival a_arrival'])
            ->join('equipments as e', 'e.id', '=', 'arrival.equipment_id')
            ->join('users as u', 'u.id', '=', 'arrival.user_id')
            ->join('categories as c', 'e.category_id', '=', 'c.id');
        if(isset($request->equipment)){
            $arrival=$arrival->whereIn('e.id',$request->equipment);
        }
        if(isset($request->category)){
            $arrival=$arrival->whereIn('c.id',$request->category);
        }
		if(isset($request->user)){
            $arrival=$arrival->whereIn('u_id',$request->user);
        }
        if(isset($request->arrival_start)){
            $arrival=$arrival->where('arrival.arrival','>=',"{$request->arrival_start}");
        }
        if(isset($request->arrival_end)){
            $arrival=$arrival->where('arrival.arrival','<=',"{$request->arrival_end}");
        }
        if(isset($request->count_start)){
            $arrival=$arrival->where('arrival.count','>=',"{$request->count_start}");
        }
        if(isset($request->count_end)){
            $arrival=$arrival->where('arrival.count','<=',"{$request->count_end}");
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
            ->join('equipments as e', 'e.id', '=', 'arrival.equipment_id')
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