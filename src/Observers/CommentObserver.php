<?php

namespace FaithGen\SDK\Observers;

use FaithGen\SDK\Events\CommentCreated;
use FaithGen\SDK\Models\Comment;
use FaithGen\SDK\Models\User;
use Illuminate\Support\Str;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  Comment  $comment
     *
     * @return void
     */
    public function created(Comment $comment)
    {
        if (!config('faithgen-sdk.source')) {
            event(new CommentCreated($comment));
        }
    }

    /**
     * @param Comment $comment
     */
    public function creating(Comment $comment)
    {
        if (Str::of($comment->creatable_type)->contains('User')) {
            $comment->creatable_type = User::class;
        }
    }
}
