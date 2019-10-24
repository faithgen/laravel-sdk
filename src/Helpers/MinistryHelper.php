<?php


namespace FaithGen\SDK\Helpers;


use FaithGen\SDK\Models\Ministry;

class MinistryHelper extends Helper
{
    public static function getImageLink($imageName, int $dimen = 0)
    {
        if ($imageName instanceof Ministry) {
            return self::getImageLink($imageName->image()->exists() ? $imageName->image->name : null, $dimen);
        }
        if (!$imageName) {
            if (!$dimen)
                $dimen = 'original';
            return asset('images/logo-' . $dimen . '.png');
        }
        if (!$dimen)
            return asset('storage/profile/original/' . $imageName);
        else
            return asset('storage/profile/' . $dimen . '-' . $dimen . '/' . $imageName);
    }
}
