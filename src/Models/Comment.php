<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToUserTrait;

class Comment extends UuidModel
{
    function commentable()
    {
        return $this->morphTo();
    }

    function creatable()
    {
        return $this->morphTo();
    }

    public function getCommentAttribute($val)
    {
        return ucfirst($val);
    }
}
