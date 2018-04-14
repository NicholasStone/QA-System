<?php

namespace App\Http\Controllers\Api\v1\Auth;

use Tymon\JWTAuth\JWTAuth;
use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Controllers\Api\v1\Controller;

class AuthorizationController extends Controller
{
    protected $auth = null;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param AuthorizationRequest $request
     *
     * 登录验证
     */
    public function store(AuthorizationRequest $request)
    {
        if (!$token = $this->guard()->attempt($request->only(['email', 'password']))) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->responseWithToken($token);
    }

    /**
     * 刷新当前凭证
     */
    public function update(){
        $token = $this->guard()->refresh();
        return $this->responseWithToken($token);
    }

    /**
     * 删除当前凭证
     */
    public function delete(){
        $this->guard()->logout();
        return $this->response->noContent();
    }
}
