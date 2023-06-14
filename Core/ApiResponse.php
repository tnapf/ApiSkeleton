<?php

namespace Core;

use HttpSoft\Response\JsonResponse;
use JsonSerializable;
use stdClass;

class ApiResponse
{
    public static function create(array|stdClass|JsonSerializable $data, int $code): JsonResponse
    {
        return new JsonResponse($data, $code);
    }

    public static function error(string $message, int $code = 500): JsonResponse
    {
        return self::create([
            'error' => $message,
            'code' => $code,
        ], $code);
    }

    public static function success(int $code = 200): JsonResponse
    {
        return self::create([
            'success' => true,
            'code' => $code,
        ], $code);
    }

    public static function successWithData(
        array|stdClass|JsonSerializable $data,
        int $code = 200
    ): JsonResponse {
        return self::create([
            'success' => true,
            'code' => $code,
            'data' => $data,
        ], $code);
    }
}
