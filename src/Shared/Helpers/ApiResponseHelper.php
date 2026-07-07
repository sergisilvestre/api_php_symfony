<?php

namespace App\Shared\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseHelper
{
    public static function success(
        mixed $data = [],
        string $message = 'OK',
        int $code = 200
    ): JsonResponse {
        return new JsonResponse([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public static function error(
        string $message = 'Error',
        int $code = 400,
        mixed $data = null
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return new JsonResponse($response, $code);
    }
}