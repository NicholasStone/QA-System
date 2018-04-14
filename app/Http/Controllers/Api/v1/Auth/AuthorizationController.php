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
     */
    public function store(AuthorizationRequest $request)
    {
        if (!$token = $this->guard()->attempt($request->only(['email', 'password']))) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->responseArray([
            'token' => $token,
            'type' => 'Bearer',
            'expires' => $this->guard()->factory()->getTTL() * 60,
            'user'=>\Auth::getUser(),
        ], 201);
    }
}
