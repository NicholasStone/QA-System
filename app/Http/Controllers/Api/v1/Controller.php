<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    protected function guard(){
        return \Auth::guard('api');
    }

    protected function responseArray(Array $array, int $statusCode = 201)
    {
        try {
            return $this->response->array($array)->setStatusCode($statusCode);
        } catch (\ErrorException $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }
}
