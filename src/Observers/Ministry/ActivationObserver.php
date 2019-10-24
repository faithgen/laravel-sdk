<?php

namespace FaithGen\SDK\Observers\Ministry;


use FaithGen\SDK\Models\Ministry\Activation;
use Webpatser\Uuid\Uuid;

class ActivationObserver
{
    function creating(Activation $activation)
    {
        $activation->code = Uuid::generate()->string;
    }
}
