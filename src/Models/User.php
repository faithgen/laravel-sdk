<?php

namespace FaithGen\SDK\Models;

use App\Traits\MinistryUserCommonsTrait;
use FaithGen\SDK\Models\Pivots\MinistryUser;

class User extends UuidModel
{
    use  MinistryUserCommonsTrait;

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

    function ministries()
    {
        return $this->belongsToMany(Ministry::class)->using(MinistryUser::class);
    }
}
