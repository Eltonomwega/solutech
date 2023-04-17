<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;
/**
 * Generalize the response message structure of the API
 */

trait ApiResponse{

    protected function success_response($data,$message=null,$code=200): JsonResponse
    {

        return response()->json([
            'status'=>'Success',
            'message'=>$message,
            'data'=>$data
        ],$code);

    }

    protected function error_response($message=null,$code): JsonResponse
    {

        return response()->json([
            'status'=>'Error',
            'message'=>$message,
        ],$code);

    }
}
