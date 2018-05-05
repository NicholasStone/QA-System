<?php

namespace App\Events;

use App\Models\QuestionTag;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class QuestionTagEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $questionTag = null;

    /**
     * Create a new event instance.
     *
     * @param QuestionTag $tag
     */
    public function __construct(QuestionTag $tag)
    {
        $this->questionTag = $tag;
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
