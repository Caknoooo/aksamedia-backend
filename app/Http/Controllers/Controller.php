<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function successWithData($data, $message): JsonResponse {
      return response()->json([
        'status' => 'success',
        'message' => $message,
        'data' => $data,
      ]);
    }

    public function success($message): JsonResponse {
      return response()->json([
        'status' => 'success',
        'message' => $message,
      ]);
    }

    public function error($message): JsonResponse {
      return response()->json([
        'status' => 'error',
        'message' => $message,
      ]);
    }

    public function errorWithCode($message, $code): JsonResponse {
      return response()->json([
        'status' => 'error',
        'message' => $message,
      ], $code);
    }
}
