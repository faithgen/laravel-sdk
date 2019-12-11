<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class MinistryUser extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'provider' => $this->user->provider,
            'picture' => $this->user->picture,
            'joined' => Helper::getDates($this->created_at)
        ];
    }
}