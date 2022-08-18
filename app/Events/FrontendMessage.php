<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FrontendMessage implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $msg;

    /**
     * Create a new event instance.
     *
     * @param mixed $order
     * @param mixed $msg
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('message.dashboard');
    }
    /*
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
}
