<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class AttachRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->verification == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:questions,id',
            'questions.*.score' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'id' => [
                'exists' => '题目不存在'
            ],
            'score' => [
                'integer' => '分数必须是整数'
            ]
        ];
    }
}
