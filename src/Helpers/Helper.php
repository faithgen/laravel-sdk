<?php


namespace FaithGen\SDK\Helpers;


use Carbon\Carbon;

class Helper
{
    public static $idValidation = 'required|string|min:12';
    public static $titleValidation = 'required|string|min:2';

    public static $freeMessagesCount = 10;

    public static function getDates(Carbon $date)
    {
        return [
            'approx' => $date->diffForHumans(),
            'formatted' => $date->format('D d M Y'),
            'exact' => $date
        ];
    }
}
