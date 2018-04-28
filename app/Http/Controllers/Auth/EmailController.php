<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-4-24
 * Time: 上午12:08
 */

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;

class EmailController extends Controller
{
    public function verify(Request $request)
    {
        try {
            $this->validate($request, ['v' => 'required',]);

            $status = [
                'status' => true,
                'message' => '您的邮件已验证成功'
            ];
            $verification = (Array)decrypt($request->get('v'));

            if ($verification['expire']->lt(now())) {
                $status['status'] = false;
                $status['message'] = '您的验证邮件已过期';
            } elseif (!$user = User::find($verification['id'])) {
                $status['status'] = false;
                $status['message'] = '此用户不存在';
            } else {
                if ($user->verification == 1) {
                    $status['status'] = false;
                    $status['message'] = '您的邮箱已验证';
                } elseif (!hash_equals($user->verification, $verification['code'])) {
                    $status['status'] = false;
                    $status['message'] = '您输入的网址非法，请重试';
                } else {
                    $user->update(['verification' => 1]);
                }
            }
        } catch (\Exception $e) {
            $status['status'] = false;
            $status['message'] = '输入的验证网址不正确，您是不是少复制一部分';
        } finally {
            return view('verification.mail-verify')->with($status);
        }
    }
}