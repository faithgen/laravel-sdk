<?php

namespace FaithGen\SDK\Models;

class Comment extends UuidModel
{
    public function commentable()
    {
        return $this->morphTo();
    }

    public function creatable()
    {
        return $this->morphTo();
    }

    public function getCommentAttribute($val)
    {
        return ucfirst($val);
    }
}
