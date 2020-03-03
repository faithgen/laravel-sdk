<?php

namespace FaithGen\SDK\Models;

use Illuminate\Support\Str;

final class Module extends UuidModel
{
    protected $guarded = ['id'];
    public $incrementing = false;

    function getNameAttribute($val)
    {
        return Str::ucfirst($val);
    }
}
