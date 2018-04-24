<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-4-24
 * Time: 上午12:08
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Models\User;

class EmailController extends Controller
{
    public function verify(EmailVerificationRequest $request, User $user)
    {
        $v = $request->get('v');

        $verification = (Array)decrypt($v);

        $user->find($verification['id'])->verification = 1;
        $user->save();
    }
}