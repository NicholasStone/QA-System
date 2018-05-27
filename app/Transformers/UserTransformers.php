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
    protected $availableIncludes = ['atom'];

    public function transform(User $user)
    {
        return [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'avatar' => $user->avatar,
            'role'   => $user->role_id,
        ];
    }

    public function includeAtom(User $user)
    {
        return $this->item([
            'created'      => $user->created_at->toDateTimeString(),
            'updated'      => $user->updated_at->toDateTimeString(),
            'introduction' => $user->introduction,
        ], new BlankTransformer());
    }
}