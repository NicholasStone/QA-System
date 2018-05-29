<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\Auth\Traits\TokenResponse;
use Dingo\Api\Http\Request;
use Dingo\Api\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\Api\AuthorizationRequest;

class AuthorizationController extends Controller
{
    use TokenResponse;

    protected $auth = null;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param AuthorizationRequest $request
     *
     * 登录验证
     * @return Response
     */
    public function store(AuthorizationRequest $request)
    {
        if (!$token = $this->guard()->attempt($request->only(['email', 'password']))) {
            $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->responseWithToken($token);
    }

    /**
     * 刷新当前凭证
     * @param Request $request
     * @return Response
     */
    public function update(Request $request){
        return $this->responseWithToken($this->guard()->refresh());
    }

    /**
     * 删除当前凭证
     */
    public function delete(){
        $this->guard()->logout();
        return $this->response->noContent();
    }
}
