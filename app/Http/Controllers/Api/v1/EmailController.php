<?php

namespace App\Http\Controllers\Api\v1;

use App\Jobs\SendVerifyEmail;

class EmailController extends Controller
{
    public function show()
    {
        if ($this->user()->verification == 1) {
            return $this->response->errorForbidden('邮箱已被验证');
        }
        if ($job = SendVerifyEmail::dispatch($this->user())->onQueue('mail')) {
            return $this->response->created();
        } else {
            return $this->response->errorInternal('验证邮件发送失败');
        }

    }
}
