<?php

namespace FaithGen\SDK\Services;

use FaithGen\SDK\Models\Ministry\Profile;
use InnoFlash\LaraStart\Services\CRUDServices;

class ProfileService extends CRUDServices
{
    protected Profile $profile;

    public function __construct()
    {
        try {
            $this->profile = auth(config('faithgen-sdk.guard'))->user()->profile;
        } catch (\Exception $e) {
        }
    }

    /**
     * Retrieves an instance of profile.
     *
     * @return \FaithGen\SDK\Models\Ministry\Profile
     */
    public function getProfile(): Profile
    {
        return $this->profile;
    }

    /**
     * This sets the attributes to be removed from the given set for updating or creating.
     * @return mixed
     */
    public function getUnsetFields(): array
    {
        return ['name', 'email', 'phone'];
    }
}
