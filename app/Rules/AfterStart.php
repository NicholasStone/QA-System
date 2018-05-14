<?php

namespace App\Rules;

use Carbon\Carbon;
use Dingo\Api\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;

class AfterStart implements Rule
{

    protected $startTime = null;

    /**
     * Create a new rule instance.
     *
     * @param FormRequest $request
     * @param $field
     */
    public function __construct(FormRequest $request, $field)
    {
        $this->startTime = Carbon::parse($request->input($field))->addMinutes(30)->timestamp;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Carbon::parse($value)->timestamp >= $this->startTime;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '过期时间应晚于早于生效时间后 30 分钟';
    }
}
