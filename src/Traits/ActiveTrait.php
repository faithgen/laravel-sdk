<?php


namespace FaithGen\SDK\Traits;

/**
 * Converts active value to boolean.
 */
trait ActiveTrait
{
    public function getActiveAttribute($val)
    {
        return (bool)$val;
    }
}
