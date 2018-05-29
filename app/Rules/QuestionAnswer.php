<?php

namespace App\Rules;

use App\Models\QuestionTag;
use Dingo\Api\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;

class QuestionAnswer implements Rule
{
    protected $request;

    /**
     * Create a new rule instance.
     *
     * @param FormRequest $request
     */
    public function __construct(FormRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     * 1. 选项最大值不能超过选项总数
     * 2. 单选题不能有多个答案
     * 3. 选项个数不得超过选项个数
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if ($this->request->input('type') == 0) {
            // 主观题
            return true;
        }

        if (!preg_match('/^\d+(,\d+)*$/', $value)) {
            return false;
        }

        $tag = (new QuestionTag)->find($this->request->input('tag'));
        $answer = collect(explode(',', $value));
        $option_number = collect($this->request->input('options'))->count(); // 选项个数

        if (!$tag->meta['multiple']) {
            // 单选
            return $answer->count() === 1   // 答案数为 1
                && intval($answer[0]) <= $option_number;    // 答案值不超过选项总数
        }

        if ($tag->meta['multiple']) {
            // 多选
            return $answer->count() <= $option_number   // 答案数不能多于选项数
                && $answer->every(function ($value) use ($option_number) {
                    return intval($value) <= $option_number;
                }); // 答案最大值不能超过选项个数
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '您提交的答案不符合规则';
    }
}
