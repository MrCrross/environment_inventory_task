<?php

namespace App\Controllers;

use App\Modules\JsonResponse;
use App\Requests\DeleteRequest;
use App\Requests\Environment\EnvironmentCreateRequest;
use App\Requests\Environment\EnvironmentFilterRequest;
use App\Requests\Environment\EnvironmentUpdateRequest;
use App\Services\EnvironmentService;

class EnvironmentController
{

    /**
     * @return void
     */
    public function index(object $request){
        EnvironmentFilterRequest::request($request);
        JsonResponse::response(EnvironmentService::get($request));
    }

    /**
     * @param object $request
     * @return void
     */
    public function show(object $request){
        JsonResponse::response(EnvironmentService::find($request->id));
    }

    /**
     * @param object $request
     * @return void
     */
    public function create(object $request){
        EnvironmentCreateRequest::request($request);
        EnvironmentService::create($request);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Оборудование(я) успешно добавлена(ы).'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function update(object $request){
        EnvironmentUpdateRequest::request($request);
        EnvironmentService::update($request,$request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Оборудование успешно изменено.'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function delete(object $request){
        DeleteRequest::request($request);
        EnvironmentService::delete($request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Оборудование успешно удалено.'
        ]);
    }
}