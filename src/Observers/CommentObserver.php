<?php

namespace FaithGen\SDK\Observers;

use FaithGen\SDK\Events\CommentCreated;
use FaithGen\SDK\Models\Comment;


class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        event(new CommentCreated($comment));
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }
}
