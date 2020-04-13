<?php

namespace FaithGen\SDK\Traits\Relationships\Belongs;

use FaithGen\SDK\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUserTrait
{
    /**
     * Relates this model to a given user.
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
