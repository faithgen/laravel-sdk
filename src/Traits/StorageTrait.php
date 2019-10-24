<?php


namespace FaithGen\SDK\Traits;


trait StorageTrait
{
    /**
     * The name of the directory in storage that has files for this model
     * @return mixed
     */
    abstract function filesDir();

    /**
     * The file name fo this model
     * @return mixed
     */
    abstract function getFileName();

    function getImageDimensions()
    {
        return [
            0, 50, 100
        ];
    }
}
