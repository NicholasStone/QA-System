<?php

namespace App\Http\Requests\Api;

use App\Rules\Captcha;
use Dingo\Api\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:4|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:20',
            'captcha' => ['required', 'array', new Captcha($this)],
        ];
    }
}
