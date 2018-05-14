<?php

namespace App\Http\Controllers\Api\v1\Auth;

use Dingo\Api\Http\Request;
//use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PasswordController extends Controller
{
    /**
     * @param Request $request
     */
    public function sendResetEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink($request->only('email'));

        $response == Password::RESET_LINK_SENT ?
            $this->response->created(null, '重置密码邮件已发送') :
            $this->response->errorNotFound('发送邮件时发送错误');
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function validateEmail(Request $request)
    {
        return $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
