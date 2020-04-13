<?php

namespace FaithGen\SDK\Models;

use FaithGen\SDK\Traits\Relationships\Has\ManyMinistryUsers;
use FaithGen\SDK\Traits\Relationships\Morphs\CreatableTrait;
use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use FaithGen\SDK\Traits\StorageTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use ManyMinistryUsers;
    use CreatableTrait;
    use Notifiable;
    use ImageableTrait;
    use StorageTrait;

    protected $table = 'fg_users';
    protected $guarded = ['id'];
    public $incrementing = false;
    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'remember_token',
    ];

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************//

    public function getNameAttribute($val)
    {
        return ucwords($val);
    }

    //****************************************************************************//
    //***************************** MODEL RELATIONSHIPS *****************************//
    //****************************************************************************//

    /**
     * Links comments to this user.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getMinistriesAttribute()
    {
        return Ministry::whereHas('ministryUsers', function ($minUser) {
            return $minUser->where('user_id', $this->id);
        });
    }

    public function getActiveAttribute(): bool
    {
        if ($user = $this->ministryUsers()->where('ministry_id', auth()->user()->id)->first()) {
            return (bool) $user->active;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function filesDir()
    {
        return 'users';
    }

    public function getFileName()
    {
        return $this->image->name;
    }

    public function getImageDimensions()
    {
        return [0, 50];
    }
}
