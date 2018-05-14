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
        $rules = null;
        if ($this->isMethod('post')) {
            $rules = [
                'tag' => ['required', 'integer', 'exists:question_tags,id'],
                'type' => ['required', 'in:0,1'],
                'question' => ['required', 'string'],
                'options' => ['required_if:type,1', 'json'],
                'answer' => ['required', 'string', new QuestionAnswer($this)],
            ];
        } else if ($this->isMethod('patch')) {
            $rules = [
                'tag' => ['integer', 'exists:question_tags,id'],
                'type' => ['in:0,1'],
                'question' => ['string'],
                'options' => ['json'],
                'answer' => ['string', new QuestionAnswer($this)],
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'options.required_if' => '选择题必须包含选项'
        ];
    }
}
