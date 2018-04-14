<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Api\v1\Controller;

class AuthController extends Controller
{
    /**
     * @param UserRequest $request
     * @return mixed
     *
     * 流程：
     * 1. 用户点击验证码输入框，js代码检查邮箱是否填写
     *
     */
    public function store(UserRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));
        $token = $this->guard()->login($user);
        return $this->registered($token);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }

    protected function registered($token)
    {
        return $this->responseWithToken($token);
    }
}
