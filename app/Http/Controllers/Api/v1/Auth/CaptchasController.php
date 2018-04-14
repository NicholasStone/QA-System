<?php

namespace App\Http\Controllers\Api\v1\Auth;

use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\Api\CaptchasRequest;

class CaptchasController extends Controller
{

    /**
     * @param CaptchasRequest $request
     * @param CaptchaBuilder $captchaBuilder
     * @return \ErrorException|\Exception
     */
    public function store(CaptchasRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captchas-' . str_random('15');
        $email = $request->input('email');

        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinute(30);

        \Cache::put($key, [
            'email' => $email,
            'code' => $captcha->getPhrase(),
        ], $expiredAt);

        try {
            return $this->response->array([
                'captcha_key' => $key,
                'expired_at' => $expiredAt->toDateTimeString(),
                'captcha_image_content' => $captcha->inline(),
            ])->setStatusCode(201);
        } catch (\ErrorException $e) {
            return $e;
        }
    }
}
