<?php

namespace FaithGen\SDK\Observers\Ministry;

use FaithGen\SDK\Models\Ministry\Activation;
use Illuminate\Support\Str;

class ActivationObserver
{
    public function creating(Activation $activation)
    {
        $activation->code = (string) Str::uuid();
    }
}
