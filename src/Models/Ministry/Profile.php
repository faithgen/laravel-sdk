<?php

namespace FaithGen\SDK\Models\Ministry;

use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use FaithGen\SDK\Models\UuidModel;

class Profile extends UuidModel
{
    use  BelongsToMinistryTrait;

    protected $casts = [
        'location' => 'array',
        'phones' => 'array',
        'emails' => 'array',
    ];

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************///

    function getVisionAttribute($val)
    {
        return ucfirst($val);
    }

    function getMissionAttribute($val)
    {
        return ucfirst($val);
    }

    //****************************************************************************//
    //***************************** MODEL ATTRIBUTES *****************************//
    //****************************************************************************//

}
