<?php

namespace FaithGen\SDK\Models;

use App\Traits\Relationships\Belongs\BelongsToUserTrait;


class Comment extends UuidModel
{
    use  BelongsToUserTrait;

    function commentable()
    {
        return $this->morphTo();
    }
}
