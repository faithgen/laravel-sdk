<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\MinistryHelper;
use FaithGen\SDK\SDK;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Http\Helper;

class MinistryUser extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->user_id,
            'active' => (bool)$this->active,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'provider' => $this->user->provider,
            'avatar' => [
                '_50' => $this->user->image()->exists() ? MinistryHelper::getImageLink($this->user->image->name, 50, 'users') : MinistryHelper::getImageLink(null, 50, 'users'),
                'original' => $this->user->image()->exists() ? MinistryHelper::getImageLink($this->user->image->name, 0, 'users') : MinistryHelper::getImageLink(null, 0, 'users'),
            ],
            'joined' => Helper::getDates($this->created_at)
        ];
    }
}
