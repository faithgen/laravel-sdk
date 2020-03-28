<?php

namespace FaithGen\SDK\Helpers;

use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\SDK;

class MinistryHelper extends Helper
{
    /**
     * Get the image link for the provided paths.
     *
     * @param $imageName
     * @param int $dimen
     * @param string $folder
     * @param bool $source
     * @return string
     */
    public static function getImageLink($imageName, int $dimen = 0, string $folder = 'profile', bool $source = false)
    {
        if ($imageName instanceof Ministry) {
            return self::getImageLink($imageName->image()->exists() ? $imageName->image->name : null, $dimen);
        }

        if (!$imageName) {
            if (!$dimen)
                $dimen = 'original';
            return SDK::getAsset('images/logo-' . $dimen . '.png', $source);
        }

        if (!$dimen)
            return SDK::getAsset('storage/' . $folder . '/original/' . $imageName, $source);
        else
            return SDK::getAsset('storage/' . $folder . '/' . $dimen . '-' . $dimen . '/' . $imageName, $source);
    }
}
