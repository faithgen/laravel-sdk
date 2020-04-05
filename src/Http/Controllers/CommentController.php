<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Events\CommenterPresence;
use FaithGen\SDK\Http\Requests\PresenceRegistryRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    /**
     * Shows other users when one is joining or leaving the discussion.
     *
     * @param  PresenceRegistryRequest  $request
     */
    public function presenceRegister(PresenceRegistryRequest $request)
    {
        if (!config('faithgen-sdk.source')) {
            event(new CommenterPresence($request->validated()));
        }
    }
}
