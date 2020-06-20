<?php

namespace FaithGen\SDK\Services;

use FaithGen\SDK\Models\Image;
use InnoFlash\LaraStart\Services\CRUDServices;

class ImageService extends CRUDServices
{
    protected Image $image;

    public function __construct()
    {
        $this->image = app(Image::class);

        $imageId = request()->route('image') ?? request('image_id');

        if ($imageId) {
            $this->image = $this->image->resolveRouteBinding($imageId);
        }
    }

    /**
     * Retrieves an instance of image.
     *
     * @return \FaithGen\SDK\Models\Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * Makes a list of fields that you do not want to be sent
     * to the create or update methods.
     * Its mainly the fields that you do not have in the messages table.
     *
     * @return array
     */
    public function getUnsetFields(): array
    {
        return ['image_id'];
    }
}
