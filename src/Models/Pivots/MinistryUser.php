<?php

namespace FaithGen\SDK\Models\Pivots;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToUserTrait;

class MinistryUser extends UuidModel
{
    use BelongsToUserTrait, BelongsToMinistryTrait;

    protected $table = 'ministry_users';
}
