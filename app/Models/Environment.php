<?php

namespace App\Models;

use App\Core\Error;
use App\Core\Model;
use PDOException;

class Environment extends Model
{
    protected string $table = 'environments';
    protected bool $deleted_at = true;

    public function paginate(object $request, int $count)
    {
        $env = self::setSelect([
            'environments.id e_id',
            'environments.name e_name',
            'environments.price e_price',
            'categories.id c_id',
            'categories.name c_name'])
            ->join('categories', 'environments.category_id', '=', 'categories.id');
        if (isset($request->name)) {
            $env = $env->where('environments.name','LIKE',"%{$request->name}%");
        }
        if(isset($request->price)){
            $env = $env->where('environments.price','LIKE',"%{$request->price}%");
        }
        if(isset($request->categories)){
            $env = $env->whereIn('categories.id',$request->categories);
        }
        if(isset($request->orderBy) and isset($request->sort)){
            $env=$env->orderBy($request->orderBy,$request->sort);
        }
        return $env->pagination($count);
    }

    /**
     * @param int $id
     * @return array|false|object|string|null
     */
    public function find(int $id)
    {
        return self::setSelect([
            'environments.id e_id',
            'environments.name e_name',
            'environments.price e_price',
            'categories.id c_id',
            'categories.name c_name'])
            ->join('categories', 'environments.category_id', '=', 'categories.id')
            ->where('environments.id', '=', $id)->select();
    }

    /**
     * @param array $request
     * @return false|string|void
     */
    public function create(array $request)
    {
        try {
            $this->connect->beginTransaction();
            $result = self::insert($request);
            $this->connect->commit();
            return $result;
        } catch (PDOException $e) {
            $this->connect->rollBack();
            Error::custom($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param array $request
     * @param int $id
     * @return false|string|void
     */
    public function edit(array $request, int $id)
    {
        try {
            $this->connect->beginTransaction();
            $result = self::where('id', '=', $id)->update($request);
            $this->connect->commit();
            return $result;
        } catch (PDOException $e) {
            $this->connect->rollBack();
            Error::custom($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return false|int|string|void
     */
    public function remove(int $id)
    {
        try {
            $this->connect->beginTransaction();
            $result = self::where('id', '=', $id)->delete();
            $this->connect->commit();
            return $result;
        } catch (PDOException $e) {
            $this->connect->rollBack();
            Error::custom($e->getCode(), $e->getMessage());
        }
    }
}