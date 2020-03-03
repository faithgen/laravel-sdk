<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MinistryModule extends Pivot
{
    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }
}
