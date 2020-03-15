<?php


namespace FaithGen\SDK\Helpers;


use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\SDK;

class MinistryHelper extends Helper
{
    public static function getImageLink($imageName, int $dimen = 0, string $folder = 'profile')
    {
        if ($imageName instanceof Ministry) {
            return self::getImageLink($imageName->image()->exists() ? $imageName->image->name : null, $dimen);
        }
        if (!$imageName) {
            if (!$dimen)
                $dimen = 'original';
            return SDK::getAsset('images/logo-' . $dimen . '.png');
        }
        if (!$dimen)
            return SDK::getAsset('storage/'.$folder.'/original/' . $imageName);
        else
            return SDK::getAsset('storage/'.$folder.'/' . $dimen . '-' . $dimen . '/' . $imageName);
    }
}
