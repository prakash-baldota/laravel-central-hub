<?php

namespace App\Helpers;

class ApiResponse
{
    // Success Response
    public static function success($message, $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    // Error Response
    public static function error($message, $errors = [], $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $errors
        ], $statusCode);
    }
}
