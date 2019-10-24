<?php

namespace FaithGen\SDK\Models;


class Image extends UuidModel
{
    /**
     * This relates all models to the image
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    function imageable()
    {
        return $this->morphTo();
    }

    function getCaptionAttribute($val)
    {
        return ucfirst($val);
    }
}
