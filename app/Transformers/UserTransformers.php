<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 18-4-23
 * Time: 下午2:21
 */

namespace App\Transformers;

use App\Models\User;
Use League\Fractal\TransformerAbstract;

class UserTransformers extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'created' => $user->created_at->toDateTimeString(),
            'updated' => $user->updated_at->toDateTimeString(),
            'role' => $user->role_id,
        ];
    }
}