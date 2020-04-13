<?php

namespace FaithGen\SDK\Traits;

/**
 * Converts active value to boolean.
 */
trait ActiveTrait
{
    public function getActiveAttribute($val)
    {
        return (bool) $val;
    }

    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }
}
