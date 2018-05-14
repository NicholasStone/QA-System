<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class QuestionTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->verification === '1';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roles = [
            'meta' => 'json'
        ];

        if ($this->isMethod('post')) {
            array_push($roles, [
                'name' => 'required|string|max:10|min:2|unique:question_tags',
                'slug' => 'required|string|max:50|unique:question_tags',
                'type' => 'required|number|in:0,1',
                'description' => 'required|string|min:8',
            ]);
        } elseif ($this->isMethod('patch')) {
            array_push($roles, [
                'name' => 'string|max:10|min:2|unique:question_tags',
                'slug' => 'string|max:50|unique:question_tags',
                'type' => 'number|in:0,1',
                'description' => 'string|min:8',
            ]);
        }
        return $roles;
    }

    public function messages()
    {
        return [
            'name' => '标签名',
            'slug' => '链接名',
            'type.in' => '类型必须是 "客观题" 或 "主观题"',
            'description' => '描述',
            'meta' => '附加选项',
        ];
    }
}
