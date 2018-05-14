<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuestionTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the questionTag.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QuestionTag  $questionTag
     * @return mixed
     */
    public function update(User $user, QuestionTag $questionTag)
    {
        return $user->id === $questionTag->user->id;
    }
}
