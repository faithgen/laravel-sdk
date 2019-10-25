<?php


namespace FaithGen\SDK\Traits;


trait TitleTrait
{
    function getTitleAttribute($val)
    {
        return ucfirst($val);
    }
}
