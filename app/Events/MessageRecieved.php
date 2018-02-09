<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageRecieved implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $channel;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel, $data)
    {
        $this->channel = $channel;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification');
    }
}