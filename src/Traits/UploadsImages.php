<?php

namespace FaithGen\SDK\Traits;

use FaithGen\SDK\Traits\Relationships\Morphs\ImageableTrait;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

trait UploadsImages
{
    private bool $isNew = true;

    /**
     * Saves the uploaded images.
     *
     * @param $model
     * @param array $images
     * @param ImageManager $imageManager
     * @param string|null $fileName
     */
    protected function uploadImages($model, array $images, ImageManager $imageManager, string $fileName = null)
    {
        if (! in_array(StorageTrait::class, class_uses($model))) {
            throw new InvalidArgumentException('The model you used does not use the Storage trait');
        }

        if (! in_array(ImageableTrait::class, class_uses($model))) {
            throw new InvalidArgumentException('The model you used does not use the Imageable trait');
        }

        foreach ($images as $imageData) {
            if (! $fileName) {
                $fileName = str_shuffle($model->id.time().time()).'.png';
            } else {
                $this->isNew = false;
            }

            $ogSave = storage_path('app/public/'.$model->filesDir().'/original/').$fileName;

            try {
                $imageManager->make($imageData)->save($ogSave);

                if ($this->isNew) {
                    $this->createImage($model, $fileName);
                } else {
                    $this->updateImage($model, $fileName);
                }
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * Creates a new image.
     *
     * @param $model
     * @param $fileName
     */
    private function createImage($model, $fileName)
    {
        $model->images()
            ->create([
                'imageable_id' => $model->id,
                'name'         => $fileName,
            ]);
    }

    /**
     * Updates pre-existing image.
     *
     * @param $model
     * @param $fileName
     */
    private function updateImage($model, $fileName)
    {
        $model->images()
            ->update([
                'name' => $fileName,
            ]);
    }
}
