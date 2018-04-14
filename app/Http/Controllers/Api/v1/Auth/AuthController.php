<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Requests\Api\UserRequest;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
        return $request->all();
        event(new Registered($user = $this->create($request->all())));
        $this->guard()->login($user);
        return $this->registered($user);
    }

    protected function guard()
    {
        return \Auth::guard();
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }

    protected function registered($user)
    {
        try {
            return $this->response->array([
                'user' => $user
            ])->setStatusCode(201);
        } catch (\ErrorException $e) {
        }
    }
}
