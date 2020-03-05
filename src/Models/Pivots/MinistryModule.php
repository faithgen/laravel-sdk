<?php

namespace FaithGen\SDK\Models\Pivots;

use FaithGen\SDK\Models\Module;
use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\ActiveTrait;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MinistryModule extends UuidModel
{
    use BelongsToMinistryTrait;
    use ActiveTrait;

    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }

    /**
     * Links this object to a module
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module() : BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
