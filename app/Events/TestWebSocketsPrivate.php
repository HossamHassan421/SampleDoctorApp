<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestWebSocketsPrivate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $message;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->message = $data['message'];
    }

    public function broadcastOn()
    {
//        return new Channel('my-channel');
        return new PrivateChannel('doctor.' . $this->id); // name: private-customer.$id
    }

    public function broadcastAs()
    {
        return 'my-test-event';
    }
}
