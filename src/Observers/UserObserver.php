<?php

namespace FaithGen\SDK\Observers;

use FaithGen\SDK\Jobs\Users\ProcessImage;
use FaithGen\SDK\Jobs\Users\S3Upload;
use FaithGen\SDK\Jobs\Users\UploadImage;
use FaithGen\SDK\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\User $user
     * @return void
     */

    function creating(User $user)
    {
        $user->id = (string)Str::uuid();
        $user->password = Hash::make(env('DEFAULT_PASSWORD', 'secret'));
    }

    public function created(User $user)
    {
        if (request()->has('image'))
            UploadImage::withChain([
                new ProcessImage($user),
                new S3Upload($user)
            ])->dispatch($user, request('image'));
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
