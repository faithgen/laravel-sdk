<?php

namespace FaithGen\SDK\Services;

use FaithGen\SDK\Models\Image;
use InnoFlash\LaraStart\Services\CRUDServices;

class ImageService extends CRUDServices
{
    private $image;

    public function __construct(Image $image)
    {
        if (request()->has('image_id')) {
            $this->image = Image::findOrFail(request('image_id'));
        } else {
            $this->image = $image;
        }
    }

    /**
     * Retrives an instance of image.
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * Makes a list of fields that you do not want to be sent
     * to the create or update methods
     * Its mainly the fields that you do not have in the images table.
     */
    public function getUnsetFields():array
    {
        return ['image_id'];
    }

    /**
     * This returns the model found in the constructor
     * or an instance of the class if no image is found.
     */
    public function getModel()
    {
        return $this->getImage();
    }
}
