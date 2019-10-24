<?php


namespace FaithGen\SDK\Traits;


trait FileTraits
{
    function getFileName(string $path)
    {
        $pieces = explode('/', $path);
        return $pieces[sizeof($pieces) - 1];
    }

    function getImage(string $dir, string $imageName, int $dimen = 0)
    {
        if ($dimen)
            $dimen = $dimen . '-' . $dimen . '/';
        else
            $dimen = 'original/';
        return storage_path('app/public/' . $dir . '/' . $dimen . $imageName);
    }

    function getImages(string $dir, string $fileName)
    {
        return [
            $this->getImage($dir, $fileName, 0),
            $this->getImage($dir, $fileName, 50),
            $this->getImage($dir, $fileName, 100),
        ];
    }

    function deleteFiles($model)
    {
        $images = [];
        foreach ($model->getImageDimensions() as $imageDimension) {
            if (is_string($model->getFileName()))
                array_push($images, $this->getImage($model->filesDir(), $model->getFileName(), $imageDimension));
            else if (is_array($model->getFileName()))
                foreach ($model->getFileName() as $filename) {
                    array_push($images, $this->getImage($model->filesDir(), $filename, $imageDimension));
                }
            else throw new \InvalidArgumentException('The file name is invalid, string or array required', 500);
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
