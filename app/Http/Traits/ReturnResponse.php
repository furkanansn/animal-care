<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait ReturnResponse {

    /**
     * @param array|object $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendSuccess(array|object $data, int $statusCode = 200): JsonResponse
    {

        return response()->json([

            'error'     => false,
            'errorMsg'  => null,
            'data'      => $data

        ], $statusCode);

    }

    /**
     * @param mixed $error
     * @param int $statusCode
     * @return JsonResponse
     */
    public function sendError(mixed $error, int $statusCode = 200): JsonResponse
    {

        return response()->json([

            'error'     => true,
            'errorMsg'  => $error,
            'data'      => null

        ], $statusCode);

    }


}
