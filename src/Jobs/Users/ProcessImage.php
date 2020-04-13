<?php

namespace FaithGen\SDK\Jobs\Users;

use FaithGen\SDK\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;
    /**
     * @var User
     */
    private User $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param ImageManager $imageManager
     * @return void
     */
    public function handle(ImageManager $imageManager)
    {
        if ($this->user->image()->exists()) {
            $ogImage = storage_path('app/public/users/original/').$this->user->image->name;
            $thumb50 = storage_path('app/public/users/50-50/').$this->user->image->name;

            $imageManager->make($ogImage)->fit(50, 50, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            }, 'center')->save($thumb50);
        }
    }
}
