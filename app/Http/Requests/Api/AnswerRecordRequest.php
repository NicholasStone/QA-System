<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class AnswerRecordRequest extends FormRequest
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
            'record'  => 'required|uuid|exists:examination_records,id',
            'answers' => 'required|array',
        ];
    }
}
