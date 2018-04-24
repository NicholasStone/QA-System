<?php

namespace App\Http\Controllers\Api\v1;

use App\Jobs\SendVerifyEmail;

class EmailController extends Controller
{
    public function show()
    {
        if ($this->user()->verification == 1){
            return $this->response->errorForbidden('邮箱已被验证');
        }
        SendVerifyEmail::dispatch($this->user())->onQueue('mail');
    }
}
