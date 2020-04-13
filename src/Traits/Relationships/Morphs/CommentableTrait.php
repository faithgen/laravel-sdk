<?php

namespace FaithGen\SDK\Traits\Relationships\Morphs;

use FaithGen\SDK\Models\Comment;

trait CommentableTrait
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
