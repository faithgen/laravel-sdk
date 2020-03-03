<?php


namespace FaithGen\SDK\Traits\Relationships\Has;


use App\MinistryModule;

trait ManyMinistryModules
{
    public function ministryModules()
    {
        return $this->hasMany(MinistryModule::class);
    }
}
