<?php

namespace FaithGen\SDK\Models\Ministry;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;

class DailyService extends UuidModel
{
    use BelongsToMinistryTrait;

    protected $table = 'fg_daily_services';
    protected $hidden = [
        'created_at',
        'updated_at',
        'ministry_id',
        'id',
    ];

    public function getAliasAttribute($val)
    {
        return ucwords($val);
    }
}
