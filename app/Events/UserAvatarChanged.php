<?php

namespace App\Events;

use App\Models\Image;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserAvatarChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $path;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param Image $image
     * @param User $user
     */
    public function __construct(Image $image, User $user)
    {
        $this->path = $image->path;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
