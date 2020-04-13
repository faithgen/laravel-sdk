<?php

namespace FaithGen\SDK\Http\Resources;

use FaithGen\SDK\Helpers\ImageHelper;
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
            'active' => (bool) $this->activation->active,
            'avatar' => ImageHelper::getImage('profile', $this->image),
        ]);

        return $results;
    }
}
