<?php

namespace FaithGen\SDK\Traits\Relationships\Has;

use FaithGen\SDK\Models\Pivots\MinistryModule;

trait ManyMinistryModules
{
    /**
     * Links the current object to many ministry modules
     *
     * @return mixed
     */
    public function ministryModules()
    {
        return $this->hasMany(MinistryModule::class);
    }
}
