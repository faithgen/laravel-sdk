<?php

namespace FaithGen\SDK\Jobs\Users;

use FaithGen\SDK\Models\User;
use FaithGen\SDK\Traits\SavesToAmazonS3;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class S3Upload implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels,
        SavesToAmazonS3;

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
     * @return void
     */
    public function handle()
    {
        try {
            $this->saveFiles($this->user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
