<?php


namespace App\Traits;


trait TitleTrait
{
    function getTitleAttribute($val)
    {
        return ucfirst($val);
    }
}
