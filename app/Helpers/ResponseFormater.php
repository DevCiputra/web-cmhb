<?php

namespace App\Helpers;


use Illuminate\Http\JsonResponse;


class ResponseFormater
{
    /**
     * Default API response format.
     *
     * @var array
     */
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];


    /**
     * Return a success JSON response.
     *
     * @param mixed $data
     * @param string|null $message
     * @return JsonResponse
     */
    public static function success($data = null, $message = null): JsonResponse
    {
        self::$response['meta']['code'] = 200;
        self::$response['meta']['status'] = 'success';
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;


        return response()->json(self::$response, self::$response['meta']['code']);
    }


    /**
     * Return an error JSON response.
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public static function error($data = null, $message = null, int $code = 400): JsonResponse
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;


        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
