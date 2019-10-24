<?php

namespace FaithGen\SDK\Listeners\Ministry\Profile\ImageSaved;

use FaithGen\SDK\Events\Ministry\Profile\ImageSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class S3Upload implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ImageSaved  $event
     * @return void
     */
    public function handle(ImageSaved $event)
    {
        //
    }
}
