<?php

namespace App\Controllers;

use App\Modules\JsonResponse;
use App\Requests\Arrival\ArrivalCreateRequest;
use App\Requests\Arrival\ArrivalFilterRequest;
use App\Requests\Arrival\ArrivalUpdateRequest;
use App\Requests\DeleteRequest;
use App\Services\ArrivalService;

class ArrivalController
{
    /**
     * @return void
     */
    public function index(object $request){
        ArrivalFilterRequest::request($request);
        JsonResponse::response(ArrivalService::get($request));
    }

    /**
     * @param object $request
     * @return void
     */
    public function show(object $request){
        JsonResponse::response(ArrivalService::find($request->id));
    }

    /**
     * @param object $request
     * @return void
     */
    public function create(object $request){
        ArrivalCreateRequest::request($request);
        ArrivalService::create($request);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Прибытие(я) успешно зарегистрировано(ы).'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function update(object $request){
        ArrivalUpdateRequest::request($request);
        ArrivalService::update($request,$request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Данные о прибытии успешно изменены.'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function delete(object $request){
        DeleteRequest::request($request);
        ArrivalService::delete($request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Данные о прибытии успешно удалены.'
        ]);
    }
}