<?php

namespace App\Controllers;

use App\Modules\JsonResponse;
use App\Requests\DeleteRequest;
use App\Requests\Equipment\EquipmentCreateRequest;
use App\Requests\Equipment\EquipmentFilterRequest;
use App\Requests\Equipment\EquipmentUpdateRequest;
use App\Services\EquipmentService;

class EquipmentController
{

    /**
     * @return void
     */
    public function index(object $request){
        EquipmentFilterRequest::request($request);
        JsonResponse::response(EquipmentService::get($request));
    }

    /**
     * @param object $request
     * @return void
     */
    public function show(object $request){
        JsonResponse::response(EquipmentService::find($request->id));
    }

    /**
     * @param object $request
     * @return void
     */
    public function create(object $request){
        EquipmentCreateRequest::request($request);
        EquipmentService::create($request);
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
        EquipmentUpdateRequest::request($request);
        EquipmentService::update($request,$request->id);
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
        EquipmentService::delete($request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Оборудование успешно удалено.'
        ]);
    }
}