<?php

namespace FaithGen\SDK\Traits\Relationships\Has;

trait ManyMinistryUser
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
