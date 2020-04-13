<?php

namespace FaithGen\SDK\Traits;

trait FileTraits
{
    public function getFileName(string $path)
    {
        $pieces = explode('/', $path);

        return $pieces[count($pieces) - 1];
    }

    public function getImage(string $dir, string $imageName, int $dimen = 0)
    {
        if ($dimen) {
            $dimen = $dimen.'-'.$dimen.'/';
        } else {
            $dimen = 'original/';
        }

        return storage_path('app/public/'.$dir.'/'.$dimen.$imageName);
    }

    public function getImages(string $dir, string $fileName)
    {
        return [
            $this->getImage($dir, $fileName, 0),
            $this->getImage($dir, $fileName, 50),
            $this->getImage($dir, $fileName, 100),
        ];
    }

    public function deleteFiles($model)
    {
        $images = [];
        foreach ($model->getImageDimensions() as $imageDimension) {
            if (is_string($model->getFileName())) {
                array_push($images, $this->getImage($model->filesDir(), $model->getFileName(), $imageDimension));
            } elseif (is_array($model->getFileName())) {
                foreach ($model->getFileName() as $filename) {
                    array_push($images, $this->getImage($model->filesDir(), $filename, $imageDimension));
                }
            } else {
                throw new \InvalidArgumentException('The file name is invalid, string or array required', 500);
            }
        }
        try {
            foreach ($images as $file) {
                unlink($file);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
