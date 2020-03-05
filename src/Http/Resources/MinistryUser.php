<?php

namespace FaithGen\SDK\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Http\Helper;

class MinistryUser extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->user_id,
            'active' => (bool) $this->active,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'provider' => $this->user->provider,
            'picture' => $this->user->picture,
            'joined' => Helper::getDates($this->created_at)
        ];
    }
}
