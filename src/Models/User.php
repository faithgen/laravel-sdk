<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Traits\Relationships\Has\ManyMinistryUser;
use FaithGen\SDK\Traits\Relationships\Morphs\CreatableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use ManyMinistryUser, CreatableTrait, HasApiTokens, Notifiable;

    protected $guarded = ['id'];
    public $incrementing = false;
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

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
