<?php

namespace FaithGen\SDK\Events\Commenter;

use FaithGen\SDK\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TypingRegistered implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var array
     */
    private array $data;
    /**
     * @var User
     */
    private User $user;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @param  array  $data
     */
    public function __construct(User $user, array $data)
    {
        $this->data = $data;
        $this->user = $user;
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

    public function broadcastWith()
    {
        return [
            'user'   => $this->user,
            'status' => $this->name.' is typing',
        ];
    }

    /**
     * Broadcast event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'user.typing';
    }
}
