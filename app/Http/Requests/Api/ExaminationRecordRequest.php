<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class ExaminationRecordRequest extends FormRequest
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
            'paper' => 'required|integer|exists:papers,id',
        ];
    }
}
