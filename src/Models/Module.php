<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Traits\Relationships\Has\ManyMinistryModules;
use Illuminate\Support\Str;

final class Module extends UuidModel
{
    use ManyMinistryModules;

    protected $guarded = ['id'];
    public $incrementing = false;

    function getNameAttribute($val)
    {
        return Str::ucfirst($val);
    }
}
