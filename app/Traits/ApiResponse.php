<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    public function success(mixed $data = null, ?string $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
        ];

        if ($data instanceof LengthAwarePaginator || $data instanceof AnonymousResourceCollection) {
            // Extract pagination meta and move the results to 'data'
            $response['data'] = $data->items(); // Just the models
            $response['meta'] = [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ];
            $response['links'] = [
                'first' => $data->url(1),
                'last' => $data->url($data->lastPage()),
                'prev' => $data->previousPageUrl(),
                'next' => $data->nextPageUrl(),
            ];
        } else {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    public function error(?string $message = null, int $code = 400, mixed $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors], $code);
    }
}
