<?php

namespace FaithGen\SDK\Services;

use InnoFlash\LaraStart\Services\CRUDServices;

class ProfileService extends CRUDServices
{
    private $profile;

    public function __construct()
    {
        try {
            $this->profile = auth(config('faithgen-sdk.guard'))->user()->profile;
        } catch (\Exception $e) {
        }
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * This sets the attributes to be removed from the given set for updating or creating.
     * @return mixed
     */
    public function getUnsetFields()
    {
        return ['name', 'email', 'phone'];
    }

    /**
     * This get the model value or class of the model in the service.
     * @return mixed
     */
    public function getModel()
    {
        return $this->getProfile();
    }
}
