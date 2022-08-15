<?php

namespace App\Core;

abstract class RequestCollector
{
    protected static function collector(array $array,string $json): object
    {
        $request=(object)[];
        if(count($array)!==0){
            foreach ($array as $key =>$value){
                $request->$key=$value;
            }
        }
        if($json!==''){
            $obj = json_decode($json);
            foreach ($obj as $key =>$value){
                $request->$key=$value;
            }
        }
        return $request;
    }
}