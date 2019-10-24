<?php

namespace FaithGen\SDK\Listeners\Ministry\Profile\ImageSaved;

use FaithGen\SDK\Events\Ministry\Profile\ImageSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\ImageManager;

class ProcessImage implements ShouldQueue
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * Create the event listener.
     *
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    /**
     * Handle the event.
     *
     * @param ImageSaved $event
     * @return void
     */
    public function handle(ImageSaved $event)
    {
        $ogImage = storage_path('app/public/profile/original/') . $event->getImage()->name;
        $thumb100 = storage_path('app/public/profile/100-100/') . $event->getImage()->name;
        $thumb50 = storage_path('app/public/profile/50-50/') . $event->getImage()->name;

        $this->imageManager->make($ogImage)->fit(100, 100, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        }, 'center')->save($thumb100);
        $this->imageManager->make($ogImage)->fit(50, 50, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        }, 'center')->save($thumb50);
    }
}
