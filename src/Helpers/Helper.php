<?php


namespace FaithGen\SDK\Helpers;


use Carbon\Carbon;

class Helper
{
    public static $idValidation = 'required|string|min:12';
    public static $titleValidation = 'required|string|min:2';
    public static $hexColorRegex = 'regex:/^#([a-fA-F0-9]{6})$/i';

    public static $freeMessagesCount = 10;
    public static $reviewTypes = ['feedback','report'];

    public static $weekDays = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];
}
