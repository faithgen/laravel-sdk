<?php

namespace FaithGen\SDK\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait SavesToAmazonS3
{
    use FileTraits;

    protected function saveFiles($model)
    {
        foreach ($model->images as $image) {
            $imageFiles = $this->getImages($model->filesDir(), $image->name, $model->getImageDimensions());

            foreach ($imageFiles as $imageFile) {
                Storage::disk('s3')->put(Str::of($imageFile)->after('public/'), fopen($imageFile, 'r+'), 'public');
            }
        }
        $this->deleteFiles($model);
    }
}
