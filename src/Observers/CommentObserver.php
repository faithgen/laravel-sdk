<?php

namespace FaithGen\SDK\Observers;

use FaithGen\SDK\Events\CommentCreated;
use FaithGen\SDK\Models\Comment;

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
}
