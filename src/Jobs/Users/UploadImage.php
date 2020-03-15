<?php

namespace FaithGen\SDK\Jobs\Users;

use FaithGen\SDK\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
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
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        if ($this->image) {
            if ($this->user->image()->exists())
                $fileName = $this->user->image->name;
            else
                $fileName = str_shuffle($this->user->id . time() . time()) . '.png';
            $ogSave = storage_path('app/public/users/original/') . $fileName;
            $imageManager->make($this->image)->save($ogSave);
            $this->user->image()->updateOrcreate([
                'imageable_id' => $this->user->id
            ], [
                'name' => $fileName
            ]);
        }
    }
}
