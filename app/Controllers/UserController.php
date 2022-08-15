<?php

namespace App\Controllers;

use App\Core\Error;
use App\Modules\JsonResponse;
use App\Requests\DeleteRequest;
use App\Requests\User\UserCreateRequest;
use App\Requests\User\UserFilterRequest;
use App\Requests\User\UserUpdateRequest;
use App\Services\UserService;

class UserController
{
    /**
     * @return void
     */
    public function get()
    {
        isset($_SESSION['user'])
            ? JsonResponse::response([
                'user' => $_SESSION['user']
        ])
            : Error::custom('401', 'Не авторизован');
    }

    /**
     * @return void
     */
    public function index(object $request){
        UserFilterRequest::request($request);
        JsonResponse::response(UserService::get($request));
    }

    /**
     * @param object $request
     * @return void
     */
    public function show(object $request){
        JsonResponse::response(UserService::find($request->id));
    }

    /**
     * @param object $request
     * @return void
     */
    public function create(object $request){
        UserCreateRequest::request($request);
        UserService::create($request);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Пользователь успешно добавлен.'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function update(object $request){
        UserUpdateRequest::request($request);
        UserService::update($request,$request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Пользователь успешно изменен.'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function delete(object $request){
        DeleteRequest::request($request);
        UserService::delete($request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Пользователь успешно удален.'
        ]);
    }
}