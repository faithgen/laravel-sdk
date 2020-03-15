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

        return $this->processResponse($request);
    }

    /**
     * Updates a user account.
     *
     * @param SaveRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function update(SaveRequest $request)
    {
        $updated = auth('web')->user()
            ->update($request->only('name', 'email'));

        return $this->processResponse($request, 'Account updated successfully.');
    }

    /**
     * Processes the response to give to the user.
     *
     * @param $request
     * @param string $messagePrefix
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function processResponse($request, string $messagePrefix = 'Account logged successfully.')
    {
        if (!$request->has('image'))
            return $this->successResponse($messagePrefix);
        else
            return $this->successResponse($messagePrefix . ' We are uploading your picture now');
    }
}
