<?php

namespace FaithGen\SDK\Observers;

use Webpatser\Uuid\Uuid;
use FaithGen\SDK\Models\User;
use Illuminate\Support\Facades\Hash;


class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */

    function creating(User $user)
    {
        $user->id = Uuid::generate()->string;
        $user->password = Hash::make(env('DEFAULT_PASSWORD'));
    }

    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
