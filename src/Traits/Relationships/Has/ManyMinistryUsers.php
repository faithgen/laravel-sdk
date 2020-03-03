<?php

namespace FaithGen\SDK\Traits\Relationships\Has;

use FaithGen\SDK\Models\Pivots\MinistryUser;

trait ManyMinistryUsers
{
    /**
     * This links this model to its ministry users entries
     * @return mixed
     */
    function ministryUsers()
    {
        return $this->hasMany(MinistryUser::class);
    }
}
