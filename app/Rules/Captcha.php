<?php

namespace App\Rules;

use Dingo\Api\Http\FormRequest;
use Illuminate\Contracts\Validation\Rule;

class Captcha implements Rule
{

    protected $request = null;

    /**
     * @var int $inValidFlag
     *
     * 1 => 超时
     * 2 => 验证码不正确
     * 3 => 邮箱不正确
     */
    protected $inValidFlag = 0;

    public function __construct(FormRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $captcha
     * @return bool
     */
    public function passes($attribute, $captcha)
    {
        $result = true;
        $cache = \Cache::get($captcha['key']);
        \Cache::forget($captcha['key']);
        if (empty($cache)) {
            $result = false;
            $this->inValidFlag = 1;
        } elseif (!hash_equals($cache['code'], $captcha['code'])) {
            $result = false;
            $this->inValidFlag = 2;
        } elseif (!hash_equals($cache['email'], $this->request->input('email'))) {
            $result = false;
            $this->inValidFlag = 3;
        }
        return $result;

//        return empty($cache) ? false :
//            hash_equals($cache['code'], $captcha['code']) && hash_equals($cache['email'], $this->request->only('email'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch ($this->inValidFlag) {
            case 1:
                return "验证超时";
            case 2:
                return "验证码不正确";
            case 3:
                return "验证邮箱不正确";
        }
    }
}