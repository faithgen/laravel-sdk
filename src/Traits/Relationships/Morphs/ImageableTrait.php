<?php


namespace FaithGen\SDK\Traits\Relationships\Morphs;


use FaithGen\SDK\Models\Image;

trait ImageableTrait
{
    function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
