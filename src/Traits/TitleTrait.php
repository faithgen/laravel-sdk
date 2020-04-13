<?php

namespace FaithGen\SDK\Traits;

trait TitleTrait
{
    public function getTitleAttribute($val)
    {
        return ucfirst($val);
    }
}
