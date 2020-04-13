<?php

namespace FaithGen\SDK\Traits;

trait StorageTrait
{
    /**
     * The name of the directory in storage that has files for this model.
     * @return mixed
     */
    abstract public function filesDir();

    /**
     * The file name fo this model.
     * @return mixed
     */
    abstract public function getFileName();

    public function getImageDimensions()
    {
        return [
            0, 50, 100,
        ];
    }
}
