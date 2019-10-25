<?php


namespace FaithGen\SDK;


class SDK
{
    public static function getAsset(string $path): string
    {
        if (config('faithgen-sdk.source'))
            return asset($path);
        else
            return config('faithgen-sdk.remoteServer') . $path;
    }
}
