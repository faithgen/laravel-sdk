<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\ImageHelper;
use FaithGen\SDK\Helpers\MinistryHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Helper;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $is_admin = $this->creatable_type === 'App\\Models\\Ministry';

        if ($is_admin)
            $avatar = ImageHelper::getImage('profile', $this->creatable->image, config('faithgen-sdk.ministries-server'));
        else
            $avatar = ImageHelper::getImage('users', $this->creatable->image, config('faithgen-sdk.users-server'));

        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'creator' => [
                'id' => $this->creatable->id,
                'name' => $this->creatable->name,
                'is_admin' => $is_admin,
                'avatar' => $avatar,
                //$this->creatable->picture ?? MinistryHelper::getImageLink($this->creatable, 50)
            ],
            'date' => Helper::getDates($this->created_at)
        ];
    }
}
