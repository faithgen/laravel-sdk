<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\MinistryHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use InnoFlash\LaraStart\Http\Helper;

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
            $avatar = [
                '_50' => $this->creatable->image()->exists() ? MinistryHelper::getImageLink($this->creatable->image->name, 50) : MinistryHelper::getImageLink(null, 50),
                '_100' => $this->creatable->image()->exists() ? MinistryHelper::getImageLink($this->creatable->image->name, 100) : MinistryHelper::getImageLink(null, 100),
                'original' => $this->creatable->image()->exists() ? MinistryHelper::getImageLink($this->creatable->image->name, 0) : MinistryHelper::getImageLink(null, 0),
            ];
        else
            $avatar = [
                '_50' => $this->creatable->image()->exists() ? MinistryHelper::getImageLink($this->creatable->image->name, 50, 'users') : MinistryHelper::getImageLink(null, 50, 'users'),
                'original' => $this->creatable->image()->exists() ? MinistryHelper::getImageLink($this->creatable->image->name, 0, 'users') : MinistryHelper::getImageLink(null, 0, 'users'),
            ];

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
