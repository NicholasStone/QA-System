<?php

namespace App\Events;

use App\Models\QuestionTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class QuestionTagEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $questionTag = null;

    /**
     * Create a new event instance.
     *
     * @param Model $tag
     */
    public function __construct(Model $tag)
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
