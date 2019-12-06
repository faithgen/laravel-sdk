<?php

namespace FaithGen\SDK\Traits\Relationships\Morphs;

use FaithGen\SDK\Models\Comment;

trait CreatableTrait
{
    function comments()
    {
        return $this->morphMany(Comment::class, 'creatable');
    }
}
