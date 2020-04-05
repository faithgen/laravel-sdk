<?php

namespace FaithGen\SDK\Events;

use FaithGen\SDK\Http\Resources\Comment as CommentsResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CommentCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $namePieces = explode('\\', $this->comment->commentable_type);
        $requiredName = Str::lower(Arr::last($namePieces));
        $requiredName = Str::plural($requiredName);

        return new PrivateChannel('comments-'.$requiredName.'-'.$this->comment->commentable_id);
    }

    public function broadcastWith()
    {
        return [
            'comment' => new CommentsResource($this->comment),
        ];
    }

    public function broadcastAs()
    {
        return 'comment.created';
    }
}
