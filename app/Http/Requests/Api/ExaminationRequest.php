<?php

namespace App\Http\Requests\Api;

use App\Rules\AfterStart;
use Dingo\Api\Http\FormRequest;

class ExaminationRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'title'      => ['required','string','between:1,255'],
                'time_limit' => ['required','integer'],
                'start_at'   => ['required','date'],
                'expire_at'  => ['required','date', new AfterStart($this,'start_at')],
            ];
        } elseif ($this->isMethod('patch')) {
            return [
                'title'      => ['string','between:1,255'],
                'time_limit' => ['integer'],
                'start_at'   => ['date'],
                'expire_at'  => ['date', new AfterStart($this, 'start_at')],
            ];
        }
    }
}
