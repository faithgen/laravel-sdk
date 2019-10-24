<?php

namespace FaithGen\SDK\Models\Ministry;

use FaithGen\SDK\Models\UuidModel;
use FaithGen\SDK\Traits\Relationships\Belongs\BelongsToMinistryTrait;

class APIKey extends UuidModel
{
    use BelongsToMinistryTrait;
}
