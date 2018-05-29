<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Paper;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaperPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the examination.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paper  $paper
     * @return mixed
     */
    public function update(User $user, Paper $paper)
    {
        return $paper->user->id === $user->id;
    }

    /**
     * Determine whether the user can delete the examination.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paper  $examination
     * @return mixed
     */
    public function delete(User $user, Paper $examination)
    {
        return $examination->user->id === $user->id;
    }
}
