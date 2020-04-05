<?php

namespace FaithGen\SDK\Events\Commenter;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPresent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var array
     */
    private array $data;

    /**
     * Create a new event instance.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('comments-'.$this->data['category'].'-'.$this->data['item_id']);
    }

    function broadcastWith()
    {
        return [
            'user' => auth('web')->user(),
            'coming_in' => (bool) $this->data['presence']
        ];
    }
}
