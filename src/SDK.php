<?php


namespace FaithGen\SDK;


class SDK
{
    public static function getAsset(string $path, bool $source = false): string
    {
        if (config('faithgen-sdk.source') || $source)
            return asset($path);
        else
            return config('faithgen-sdk.remoteServer') . $path;
    }
}
