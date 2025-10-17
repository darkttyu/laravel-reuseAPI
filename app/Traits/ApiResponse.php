<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ApiResponse
{
    /**
     * Generate a JSON response for a successful API request.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse($data, $message = 'Success', $statusCode = 200): JsonResponse
    {
        Log::info($data);
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Generate a JSON response for a failed API request.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse($message, $statusCode, $trace = null, $line = null, $file = null): JsonResponse
    {
        Log::error($message);
        return response()->json([
            'success' => false,
            'message' => $message,
            'trace' => $trace,
            'line' => $line,
            'file' => $file,
        ], $statusCode);
    }
}
