<?php

namespace App\Utils;

use Illuminate\Validation\ValidationException;

class ResponseFormatter
{
  protected static $response = [
    'meta' => [
      'code' => 200,
      'status' => 'success',
      'message' => null
    ],
    'data' => null,
  ];

  public static function success($data = null, $message = null)
  {
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;
    self::$response['timestamp'] = now();

    return response()->json(self::$response, self::$response['meta']['code']);
  }

  public static function error($data = null, $message = null, $code = 400)
  {
    self::$response['meta']['status'] = 'error';
    self::$response['meta']['code'] = $code;
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;
    self::$response['timestamp'] = now();

    return response()->json(self::$response, self::$response['meta']['code']);
  }

  public static function validasiError(ValidationException $error)
  {
    self::$response['meta']['status'] = 'validasi_error';
    self::$response['meta']['code'] = 400;
    self::$response['meta']['message'] = "Validasi Error";
    self::$response['data'] = $error->validator->getMessageBag();
    self::$response['timestamp'] = now();

    return response()->json(self::$response, self::$response['meta']['code']);
  }

}
