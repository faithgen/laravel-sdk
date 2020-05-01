<?php

namespace FaithDen\SDK\Tests\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ministry extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
