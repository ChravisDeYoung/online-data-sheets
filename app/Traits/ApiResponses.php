<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait responsible for handling API responses.
 */
trait ApiResponses
{
    /**
     * Return a success response.
     *
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function success($message, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }
}
