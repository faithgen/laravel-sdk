<?php

namespace FaithGen\SDK\Models\Ministry;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;

class Profile extends UuidModel
{
    use  BelongsToMinistryTrait;

    protected $table = 'fg_profiles';

    protected $casts = [
        'location' => 'array',
        'phones' => 'array',
        'emails' => 'array',
    ];

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************///

    public function getVisionAttribute($val)
    {
        return ucfirst($val);
    }

    public function getMissionAttribute($val)
    {
        return ucfirst($val);
    }

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************//
}
