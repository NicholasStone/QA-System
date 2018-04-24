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
        if ($this->method() === 'post') {
            $rules = [
                'name' => 'required|regex:/^[A-Za-z0-9\-\_]+$|between:4,20|unique:users',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6|max:20',
                'captcha' => ['required', 'array', new Captcha($this)],
            ];
        } elseif ($this->method() === 'patch') {
            $rules = [
                'name' => 'string|min:4|max:20|unique:users',
                'introduction' => 'string|max:50',
            ];
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'introduction' => '个人简介'
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
        ];
    }
}
