<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

if(!function_exists('get_all')){
    function get_all(Model $model){
        return $model::where('deleted_at','=',null)->get();
    }
}

if(!function_exists('get_one')){
    function get_one(Model $model,string $id,string $property=null){
        return $model::where('deleted_at','=',null)->where($property??'id','=',$id);
    }
}

if(!function_exists('post_record')){
    function post_record(Model $model,Request $request,array $validation_fields){
        $request->validate($validation_fields);
        return $model::create($request->all());
    }
}

if (!function_exists('update_record')){
    function update_record(Model $model,Request $request,string $id,array $validation_fields){
        $record = $model::findOrFail($id);
        foreach ($request->all() as $field => $value){
            if (array_key_exists($field,$validation_fields)){
                $request->validate([$field=>$validation_fields[$field]]);
                $record->$field = $value;
            }
        }
        return $record->save();
    }
}

if(!function_exists('delete_record')){
    function delete_record(Model $model,String $id){
        //soft delete
        $record = $model::findOrFail($id);
        $record->deleted_at = Carbon::now();
        return $record->save();
    }

}
