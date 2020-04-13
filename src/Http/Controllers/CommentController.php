<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Events\Commenter\TypingRegistered;
use FaithGen\SDK\Events\Commenter\UserPresent;
use FaithGen\SDK\Http\Requests\PresenceRegistryRequest;
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
        if (! config('faithgen-sdk.source')) {
            event(new UserPresent(auth('web')->user(), $request->validated()));
        }
    }

    /**
     * Registers to other users when one is typing a comment.
     *
     * @param  PresenceRegistryRequest  $request
     */
    public function showTyping(PresenceRegistryRequest $request)
    {
        if (! config('faithgen-sdk.source')) {
            event(new TypingRegistered(auth('web')->user(), $request->validated()));
        }
    }
}
