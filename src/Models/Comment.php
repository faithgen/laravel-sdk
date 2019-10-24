<?php

namespace FaithGen\SDK\Models;



use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToUserTrait;

class Comment extends UuidModel
{
    use  BelongsToUserTrait;

    function commentable()
    {
        return $this->morphTo();
    }
}
