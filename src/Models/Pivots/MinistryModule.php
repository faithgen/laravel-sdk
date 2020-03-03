<?php

namespace FaithGen\SDK\Models\Pivots;

use FaithGen\SDK\Models\Module;
use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MinistryModule extends UuidModel
{
    use BelongsToMinistryTrait;

    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }

    /**
     * Links this object to a module
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
