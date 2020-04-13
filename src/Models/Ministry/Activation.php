<?php

namespace FaithGen\SDK\Models\Ministry;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;

class Activation extends UuidModel
{
    use BelongsToMinistryTrait;

    protected $table = 'fg_activations';
}
