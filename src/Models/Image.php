<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Traits\Relationships\Morphs\CommentableTrait;

class Image extends UuidModel
{
    use CommentableTrait;

    /**
     * This relates all models to the image.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    public function getCaptionAttribute($val)
    {
        return ucfirst($val);
    }
}
