<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use App\Http\Requests\Api\UserRequest;
use App\Transformers\UserTransformers;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Api\v1\Controller;
use App\Http\Controllers\Api\v1\Auth\Traits\TokenResponse;

/**
 * user as resource
 */
class UserController extends Controller
{
    use TokenResponse;

    /**
     * 用户信息 API
     * @return \Dingo\Api\Http\Response
     */
    public function show()
    {
        return $this->response->item($this->guard()->user(), new UserTransformers());
    }

    /**
     * × 更新用户信息
     * @param UserRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(UserRequest $request)
    {
        $attribute = $request->only(['name', 'introduction']);
        // return $this->response->array($attribute);
        $user = $this->user();
        $user->update($attribute);
        return $this->response->item($user, new UserTransformers())->setStatusCode(201);
    }

    /**
     * @param UserRequest $request
     * @return mixed
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
            'password' => bcrypt($data['password']),
            'verification' => str_random(15)
        ]);
    }

    protected function registered($token)
    {
        return $this->responseWithToken($token);
    }
}
