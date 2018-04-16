<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\User;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Api\v1\Controller;
/**
 * user as resource
 */
class AuthController extends Controller
{

    public function show()
    {
        return $this->guard()->user();
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
            'password' => bcrypt($data['password'])
        ]);
    }

    protected function registered($token)
    {
        return $this->responseWithToken($token);
    }
}
