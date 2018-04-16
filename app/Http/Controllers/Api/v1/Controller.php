<?php

namespace App\Http\Controllers\Api\v1;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    protected function guard()
    {
        return \Auth::guard('api');
    }

    protected function responseArray(Array $array, int $statusCode = 200)
    {
        try {
            return $this->response->array($array)->setStatusCode($statusCode);
        } catch (\ErrorException $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    // protected function responseWithToken(string $token)
    // {
    //     return $this->responseArray([
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //         'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
    //     ]);
    // }

    protected function responseWithToken(string $token, $request = null)
    {

        $response = [
            'token' => $token,
            'type' => 'Bearer',
            'expiration' => \Auth::guard('api')->factory()->getTTL() * 60
        ];
        if (config('app.debug') && !empty($request)) {
            array_push($response, [
                'data' => [
                    'body' => $request->all(),
                    'head' => $request->header(),
                ]
            ]);
        }
        return $this->responseArray($response);
    }
}
