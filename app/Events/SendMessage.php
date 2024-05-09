<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $chatData;

    /**
     * sendMessage constructor.
     * @param $chatData
     */
    public function __construct($chatData)
    {
        $this->chatData = $chatData;
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        return ['chat' => $this->chatData];
    }

    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'getChatMessage';
    }

    /**
     * @return PrivateChannel[]
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat-message'),
        ];
    }
}
