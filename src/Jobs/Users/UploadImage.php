<?php

namespace FaithGen\SDK\Jobs\Users;

use FaithGen\SDK\Models\User;
use FaithGen\SDK\Traits\UploadsImages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class UploadImage implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        UploadsImages;

    public bool $deleteWhenMissingModels = true;
    /**
     * @var User
     */
    private User $user;
    /**
     * @var string
     */
    private string $image;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $image
     */
    public function __construct(User $user, string $image)
    {
        $this->user = $user;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @param ImageManager $imageManager
     *
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        if ($this->image) {
            if ($this->user->image()->exists()) {
                $fileName = $this->user->image->name;
                $this->uploadImages($this->user, [$this->image], $imageManager, $fileName);
            } else {
                $this->uploadImages($this->user, [$this->image], $imageManager);
            }
        }
    }
}
