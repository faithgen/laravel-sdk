<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\ImageHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Helper;

class MinistryUser extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->user_id,
            'active'   => (bool) $this->active,
            'name'     => $this->user->name,
            'email'    => $this->user->email,
            'phone'    => $this->user->phone,
            'provider' => $this->user->provider,
            'avatar'   => ImageHelper::getImage('users', $this->user->image, config('faithgen-sdk.users-server')),
            'joined'   => Helper::getDates($this->created_at),
        ];
    }
}
