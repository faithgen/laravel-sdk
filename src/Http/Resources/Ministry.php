<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\ImageHelper;
use FaithGen\SDK\Helpers\MinistryHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class Ministry extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $results = parent::toArray($request);
        $results = array_merge($results, [
            'active' => (boolean)$this->activation->active,
            'avatar' => ImageHelper::getImage('profile', $this->image)
            /*            'avatar' => [
                            '_50' => $this->image()->exists() ? MinistryHelper::getImageLink($this->image->name, 50) : MinistryHelper::getImageLink(null, 50),
                            '_100' => $this->image()->exists() ? MinistryHelper::getImageLink($this->image->name, 100) : MinistryHelper::getImageLink(null, 100),
                            'original' => $this->image()->exists() ? MinistryHelper::getImageLink($this->image->name, 0) : MinistryHelper::getImageLink(null, 0),
                        ]*/
        ]);
        return $results;
    }
}
