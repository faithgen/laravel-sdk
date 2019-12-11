<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\MinistryHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'active' => (bool) $this->activation->active,
            'api_key' => $this->apiKey->api_key,
            'avatar' => [
                '_50' => $this->image()->exists() ? MinistryHelper::getImageLink($this->image->name, 50) : MinistryHelper::getImageLink(null, 50),
                '_100' => $this->image()->exists() ? MinistryHelper::getImageLink($this->image->name, 100) : MinistryHelper::getImageLink(null, 100),
                'original' => $this->image()->exists() ? MinistryHelper::getImageLink($this->image->name, 0) : MinistryHelper::getImageLink(null, 0),
            ],
            'date' => MinistryHelper::getDates($this->created_at),
            'users' => [
                'count' => $this->ministryUsers()->count()
            ],
            'location' => $this->profile->location,
            'links' => [
                'website' => $this->profile->website,
                'facebook' => $this->profile->facebook,
                'youtube' => $this->profile->youtube,
                'twitter' => $this->profile->twitter,
                'instagram' => $this->profile->instagram,
            ],
            'contact' => [
                'phones' => $this->phones,
                'emails' => $this->emails,
            ],
            'services' => DailyService::collection($this->services),
            'statement' => [
                'vision' => $this->profile->vision,
                'mission' => $this->profile->mission,
                'about_us' => $this->profile->about_us,
            ],
        ];
    }
}
