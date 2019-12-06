<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Models\Pivots\MinistryUser;
use FaithGen\SDK\Traits\Relationships\Has\ManyMinistryUser;
use FaithGen\SDK\Traits\Relationships\Morphs\CreatableTrait;

class User extends UuidModel
{
    use ManyMinistryUser, CreatableTrait;

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************//

    function getNameAttribute($val)
    {
        return ucwords($val);
    }

    //****************************************************************************//
    //***************************** MODEL RELATIONSHIPS *****************************//
    //****************************************************************************//

    /**
     * Links comments to this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function comments()
    {
        return $this->hasMany(Comment::class);
    }

    function getMinistriesAttribute()
    {
        return Ministry::whereHas('ministryUsers', function ($minUser) {
            return $minUser->where('user_id', $this->id);
        });
    }
}
