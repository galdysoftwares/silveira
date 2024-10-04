<?php

declare(strict_types = 1);

namespace App\Traits\Api;

use Illuminate\Http\JsonResponse;

trait Responses
{
    protected function ok(?string $message, array $data = []): JsonResponse
    {
        return $this->success($message, $data, 200);
    }

    protected function success(?string $message, array $data = [], int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status'  => $statusCode,
            'data'    => $data,
        ], $statusCode);
    }

    protected function error(?string $message, ?int $statusCode): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status'  => $statusCode,
        ], $statusCode);
    }
}
