<?php

namespace App\Listeners;

use App\Events\UserAvatarChanged;

class ChangeAvatar
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserAvatarChanged $event
     * @return void
     */
    public function handle(UserAvatarChanged $event)
    {
        $event->user->avatar = $event->path;
        $event->user->save();
    }
}
