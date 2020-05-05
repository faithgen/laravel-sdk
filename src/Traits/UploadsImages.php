<?php

namespace FaithGen\SDK\Traits;

use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

trait UploadsImages
{
    /**
     * Saves the uploaded images.
     *
     * @param $model
     * @param array $images
     * @param ImageManager $imageManager
     */
    protected function uploadImages($model, array $images, ImageManager $imageManager)
    {
        if (! in_array(StorageTrait::class, class_uses($model))) {
            throw new InvalidArgumentException('The model you used does not use the Storage trait');
        }

        if (! in_array(ImageableTrait::class, class_uses($model))) {
            throw new InvalidArgumentException('The model you used does not use the Imageable trait');
        }

        foreach ($images as $imageData) {
            $fileName = str_shuffle($model->id.time().time()).'.png';
            $ogSave = storage_path('app/public/'.$model->filesDir().'/original/').$fileName;
            try {
                $imageManager->make($imageData)->save($ogSave);
                $model->images()->create([
                    'imageable_id' => $model->id,
                    'name'         => $fileName,
                ]);
            } catch (\Exception $e) {
            }
        }
    }
}
