<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Traits\ActiveTrait;
use FaithGen\SDK\Traits\Relationships\Has\ManyMinistryModules;
use Illuminate\Support\Str;

final class Module extends UuidModel
{
    use ManyMinistryModules;
    use ActiveTrait;

    protected $guarded = ['id'];
    public $incrementing = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    function getNameAttribute($val)
    {
        return Str::ucfirst($val);
    }

    /**
     * Checks is if the authenticated user is using this module
     *
     * @return bool
     */
    function getUsedAttribute(): bool
    {
        if (!auth()->user()) return false;
        return (bool)$this->ministryModules()
            ->where('ministry_id', auth()->user()->id)
            ->active()
            ->count();
    }
}
