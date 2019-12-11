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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $is_admin = $this->creatable_type === 'App\\Models\\Ministry';
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'creator' => [
                'id' => $this->creatable->id,
                'name' => $this->creatable->name,
                'is_admin' => $is_admin,
                'picture' => $this->creatable->picture ?? MinistryHelper::getImageLink($this->creatable, 50)
            ],
            'date' => Helper::getDates($this->created_at)
        ];
    }
}
