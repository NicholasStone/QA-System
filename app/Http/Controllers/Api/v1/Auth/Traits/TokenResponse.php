<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-4-23
 * Time: 下午2:41
 */

namespace App\Http\Controllers\Api\v1\Auth\Traits;


trait TokenResponse
{
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

        try {
            return $this->response->array($response)->setStatusCode(200);
        } catch (\ErrorException $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }
}