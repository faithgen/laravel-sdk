<?php

namespace FaithGen\SDK\Models\Pivots;

use FaithGen\SDK\Models\UuidModel;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MinistryModule extends UuidModel
{
    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }
}
