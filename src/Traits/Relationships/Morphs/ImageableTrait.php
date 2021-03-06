<?php

namespace FaithGen\SDK\Traits\Relationships\Morphs;

use FaithGen\SDK\Models\Image;

trait ImageableTrait
{
    /**
     * Links many images to the given model.
     *
     * @return mixed
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Links one image to the given model.
     *
     * @return mixed
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
