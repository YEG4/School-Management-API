<?php

namespace App\Helpers;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ErrorResponse
{
    use ApiResponse {
        ApiResponse::error as errorResponse;
    }

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function error(?string $message = null, int $code = 400, mixed $errors = null): JsonResponse
    {
        return $this->errorResponse($message, $code, $errors);
    }
}
