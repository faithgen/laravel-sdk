<?php

namespace FaithGen\SDK\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

trait SavesToAmazonS3
{
    use FileTraits;

    /**
     * Saves model images to Amazon s3.
     *
     * @param $model
     */
    protected function saveFiles($model)
    {
        if (! in_array(StorageTrait::class, class_uses($model))) {
            throw new InvalidArgumentException('The model you used does not use the Storage trait');
        }

        foreach ($model->images as $image) {
            $imageFiles = $this->getImages($model->filesDir(), $image->name, $model->getImageDimensions());

            foreach ($imageFiles as $imageFile) {
                Storage::disk('s3')->put(Str::of($imageFile)->after('public/'), fopen($imageFile, 'r+'), 'public');
            }
        }
        $this->deleteFiles($model);
    }
}
