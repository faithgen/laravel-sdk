<?php


namespace FaithGen\SDK\Traits\Relationships\Belongs;


use FaithGen\SDK\Models\Ministry;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToMinistryTrait
{
    /**
     * Relates this account to a ministry
     * @return BelongsTo
     */
    function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }
}
