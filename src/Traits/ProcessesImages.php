<?php

namespace FaithGen\SDK\Traits;

use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

trait ProcessesImages
{
    use FileTraits;

    /**
     * Creates thumbnails for the given model.
     *
     * @param ImageManager $imageManager
     * @param $model
     */
    protected function processImage(ImageManager $imageManager, $model)
    {
        if (! in_array(StorageTrait::class, class_uses($model))) {
            throw new InvalidArgumentException('The model you used does not use the Storage trait');
        }

        if ($model->images()->exists()) {
            foreach ($model->images as $image) {
                $originalFile = $this->getImage($model->filesDir(), $image->name);

                $thumbNailsDimensions = collect($model->getImageDimensions())
                    ->except(0)
                    ->toArray();

                foreach ($thumbNailsDimensions as $thumbNailsDimension) {
                    try {
                        $thumbNail = $this->getImage($model->filesDir(), $image->name, $thumbNailsDimension);
                        $imageManager
                            ->make($originalFile)
                            ->fit($thumbNailsDimension, $thumbNailsDimension,
                                function ($constraint) {
                                    $constraint->upsize();
                                    $constraint->aspectRatio();
                                }, 'center')
                            ->save($thumbNail);
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            }
        }
    }
}
