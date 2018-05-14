<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Examination;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExaminationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the examination.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Examination  $examination
     * @return mixed
     */
    public function update(User $user, Examination $examination)
    {
        return $examination->user->id === $user->id;
    }

    /**
     * Determine whether the user can delete the examination.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Examination  $examination
     * @return mixed
     */
    public function delete(User $user, Examination $examination)
    {
        return $examination->user->id === $user->id;
    }
}
