<?php

namespace App\Models;

use App\Core\Error;
use App\Core\Model;
use PDOException;

class User extends Model
{

    protected string $table = 'users';
    protected bool $deleted_at = true;

    public static function checkAuth(): bool
    {
        if(isset($_SESSION['user']) and is_object($_SESSION['user'])){
            return true;
        }
        return false;
    }

    public static function addSession($user){
        $_SESSION['user'] = $user[0];
    }
    /**
     * @param string $name
     * @param string $password
     * @return bool
     */
    public function check(string $name, string $password): bool
    {
        if(User::checkAuth()){
            Error::custom(403, 'Уже авторизован');
        }
        $user =self::setSelect(['id','name'])->where('name', '=', $name)->where('password', '=', $password)->limit(1)->select();
        if (count($user) !== 0) {
            self::addSession($user);
            return true;
        }
        return false;
    }

    /**
     * @param string $name
     * @param string $password
     * @return void
     */
    public function registration(string $name, string $password)
    {
        try {
            $this->connect->beginTransaction();
            $user =self::where('name', '=', $name)->where('password', '=', $password)->limit(1)->select();
            if (count($user) !== 0) {
                Error::custom(403, 'Уже авторизован');
            }
            $id = self::insert([
                'name' => $name,
                'password' => $password
            ]);
            $data = self::setSelect(['id','name'])->where('id', '=', $id)->select();
            $this->connect->commit();
            self::addSession($data);
        } catch (PDOException $e) {
            $this->connect->rollBack();
            Error::custom($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param object $request
     * @param int $count
     * @return array|false|object|string|null
     */
    public function paginate(object $request,int $count){
        $user=new User();
        if(isset($request->name)){
            $user=$user->where('name','LIKE',"%{$request->name}%");
        }
        if(isset($request->orderBy) and isset($request->sort)){
            $user=$user->orderBy($request->orderBy,$request->sort);
        }
        return $user->pagination($count);
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
            $result = self::where('id','=',$id)->delete();
            $this->connect->commit();
        }catch(PDOException $e){
            $this->connect->rollBack();
            Error::custom($e->getCode(),$e->getMessage());
        }
    }
}