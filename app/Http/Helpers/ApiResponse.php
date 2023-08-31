<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function errorResponse($status,$message,$errors, $statusCode)
    {
        $response = [
            "status" => false,
            "errors"=>$errors,
            "message" => $message,
            "state-code" => $statusCode
        ];
        
        return response()->json($response, $statusCode);
    }
    public static function successResponse($status,$message,$data, $statusCode)
    {
        $response = [
            "status" => true,
            "message" => $message,
            "data" => $data,
            "state-code" => $statusCode
        ];
        
        return response()->json($response, $statusCode);
    }


}
