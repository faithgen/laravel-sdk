<?php

namespace FaithGen\SDK\Traits\Relationships\Has;

use FaithGen\SDK\Models\Pivots\MinistryModule;

trait ManyMinistryModules
{
    public function ministryModules()
    {
        return $this->hasMany(MinistryModule::class);
    }
}
