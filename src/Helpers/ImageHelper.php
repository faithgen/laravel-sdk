<?php

namespace FaithGen\SDK\Helpers;

use FaithGen\SDK\Models\Image;

class ImageHelper
{
    /**
     * Fetches the image url.
     *
     * @param string $server
     * @param string $folder
     * @param Image|null $image
     * @return object
     */
    private static function getImages(string $server, string $folder, ?Image $image): object
    {
        if ($image)
            $imageName = $image->name;
        else return static::getDefaultImage();

        return (object)[
            '_50' => $server . '/storage/' . $folder . '/50-50/' . $imageName,
            '_100' => $server . '/storage/' . $folder . '/100-100/' . $imageName,
            'original' => $server . '/storage/' . $folder . '/original/' . $imageName,
        ];
    }

    /**
     * Fetches the system logo for default images.
     *
     * @return object
     */
    private static function getDefaultImage()
    {
        return (object)[
            '_50' => $_SERVER['HTTP_HOST'] . '/images/logo-50.png',
            '_100' => $_SERVER['HTTP_HOST'] . '/images/logo-100.png',
            'original' => $_SERVER['HTTP_HOST'] . '/images/logo-original.png',
        ];
    }

    /**
     * Gets the image object for the given object.
     *
     * @param string $folder
     * @param Image|null $image
     * @param string|null $server
     * @return object
     */
    public static function getImage(string $folder, ?Image $image, ?string $server = null)
    {
        if (!$server)
            $server = $_SERVER['HTTP_HOST'];

        return static::getImages($server, $folder, $image);
    }
}
