<?php

namespace App\Controllers;

use App\Modules\JsonResponse;
use App\Requests\Category\CategoryCreateRequest;
use App\Requests\Category\CategoryFilterRequest;
use App\Requests\Category\CategoryUpdateRequest;
use App\Requests\DeleteRequest;
use App\Services\CategoryService;

class CategoryController
{
    /**
     * @return void
     */
    public function index(object $request){
        CategoryFilterRequest::request($request);
        JsonResponse::response(CategoryService::get($request));
    }

    /**
     * @param object $request
     * @return void
     */
    public function show(object $request){
        JsonResponse::response(CategoryService::find($request->id));
    }

    /**
     * @param object $request
     * @return void
     */
    public function create(object $request){
        CategoryCreateRequest::request($request);
        CategoryService::create($request);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Категория(и) успешно добавлена(ы).'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function update(object $request){
        CategoryUpdateRequest::request($request);
        CategoryService::update($request,$request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Категория успешно изменена.'
        ]);
    }

    /**
     * @param object $request
     * @return void
     */
    public function delete(object $request){
        DeleteRequest::request($request);
        CategoryService::delete($request->id);
        JsonResponse::response([
            'status'=>'200',
            'message'=>'Категория успешно удалена.'
        ]);
    }
}