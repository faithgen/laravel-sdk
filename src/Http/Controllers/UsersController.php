<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Http\Requests\Users\SaveRequest;
use FaithGen\SDK\Models\User;
use Illuminate\Routing\Controller;
use InnoFlash\LaraStart\Traits\APIResponses;

class UsersController extends Controller
{
    use APIResponses;

    /**
     * Registers a user to the given ministry.
     *
     * @param SaveRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function register(SaveRequest $request)
    {
        $user = User::create($request->only('name', 'email'));

        auth()->user()->ministryUsers()->create([
            'user_id' => $user->id
        ]);

        if (!$request->has(image))
            return $this->successResponse('Account logged successfully.');
        else
            return $this->successResponse('Account logged successfully, we are uploading your picture now');
    }
}
