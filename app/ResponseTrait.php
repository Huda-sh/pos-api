<?php

namespace App;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function success($message, $data = null, $token = null, $code = 200, $id = null): JsonResponse
    {
        $response = [
            'message' => $message,
            'success' => true,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        if ($token !== null) {
            $response['token'] = $token;
        }

        if ($id !== null) {
            $response['id'] = $id;
        }

        return response()->json($response, $code);
    }

    public function notFound($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => false,
        ], 404);
    }

    public function error($message, $code = 400): JsonResponse
    {
        return response()->json([
            'errors' => $message,
            'success' => false,
        ], $code);
    }

    public function unauthorized($role): JsonResponse
    {
        return response()->json([
            'errors' => 'only '.$role.' can access this request',
            'success' => false,
        ], 403);
    }

    public function validationError($message, $errors, $code = 422): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
            'success' => false,
        ], $code);
    }

    public function serverError($message): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'success' => false,
        ], 500);
    }
}
