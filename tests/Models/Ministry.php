<?php

namespace FaithDen\SDK\Tests\Models;

use FaithGen\SDK\Traits\Relationships\Has\ManyMinistryUsers;

class Ministry extends \FaithGen\SDK\Models\Ministry
{
    use ManyMinistryUsers;
}
