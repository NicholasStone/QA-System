<?php

namespace App\Http\Requests\Api;

use App\Rules\QuestionAnswer;
use Dingo\Api\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        $rules = [
            'options' => 'required_if:type,1|json',
        ];

        if ($this->isMethod('post')) {
            $rules = array_merge($rules, [
                'tag' => 'required|integer|exists:question_tags,id',
                'type' => 'required|in:0,1',
                'title' => 'required|string',
                'answer' => ['required', 'string', new QuestionAnswer($this)],
            ]);
        } else if ($this->isMethod('patch')) {
            $rules = array_merge($rules, [
                'tag' => 'integer',
                'type' => 'in:0,1',
                'title' => 'string',
                'answer' => 'string',
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'options.regex' => '答案只能包含数字和英文逗号(",")',
            'options.required_if' => ''
        ];
    }
}
