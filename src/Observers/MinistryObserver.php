<?php

namespace FaithGen\SDK\Observers;

use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Notifications\Ministry\AccountCreated;
use FaithGen\SDK\Traits\FileTraits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MinistryObserver
{
    use FileTraits;

    public function creating(Ministry $ministry)
    {
        $ministry->password = Hash::make(request()->password);
        $ministry->id = (string) Str::uuid();
    }

    /**
     * Handle the ministry "created" event.
     *
     * @param \App\Models\Ministry $ministry
     * @return void
     * @throws \Exception
     */
    public function created(Ministry $ministry)
    {
        $ministry->profile()->save(new Ministry\Profile());
        $ministry->account()->save(new Ministry\Account());
        $ministry->activation()->save(new Ministry\Activation());
        $ministry->apiKey()->save(new Ministry\APIKey([
            'api_key' => str_shuffle(Uuid::generate()->string),
        ]));

        $ministry->notify(new AccountCreated($ministry));
    }

    /**
     * Handle the ministry "updated" event.
     *
     * @param Ministry $ministry
     * @return void
     */
    public function updated(Ministry $ministry)
    {
        // dump('has services');
        if (request()->has('services')) {
            $ministry->services()->insert(request()->services);
        }
    }

    /**
     * Handle the ministry "deleted" event.
     *
     * @param Ministry $ministry
     * @return void
     */
    public function deleted(Ministry $ministry)
    {
        //todo remove aa lotta staff related to this ministry
        if ($ministry->image()->exists()) {
            $ministry->image()->delete();
        }

        try {
            $this->deleteFiles($ministry);
        } catch (\Exception $e) {
        }
    }
}
