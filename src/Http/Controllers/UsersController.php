<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Http\Requests\Users\LoginRequest;
use FaithGen\SDK\Http\Requests\Users\SaveRequest;
use FaithGen\SDK\Http\Resources\MinistryUser;
use FaithGen\SDK\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function register(SaveRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'phone'));

        $ministryUser = auth()->user()->ministryUsers()->create([
            'user_id' => $user->id,
        ]);

        return $this->processResponse($request, $ministryUser, 'Account created successfully.');
    }

    /**
     * Updates a user account.
     *
     * @param SaveRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SaveRequest $request)
    {
        $updated = auth('web')->user()
            ->update($request->only('name', 'email', 'phone'));

        $ministryUser = auth()->user()
            ->ministryUsers()
            ->where('user_id', auth('web')->user()->id)
            ->first();

        return $this->processResponse($request, $ministryUser, 'Account updated successfully.');
    }

    /**
     * Logs in the user into the app.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws ModelNotFoundException
     */
    public function login(LoginRequest $request)
    {
        $ministryUser = auth()->user()
            ->ministryUsers()
            ->whereHas('user', fn ($user) => $user->where($request->validated()))
            ->first();

        if ($ministryUser) {
            return $this->processResponse($request, $ministryUser, 'Login successful.');
        } else {
            abort(401, 'This phone number is not valid for this app');
        }
    }

    /**
     * Processes the response to give to the user.
     *
     * @param $request
     * @param MinistryUser $ministryUser
     * @param string $messagePrefix
     * @return \Illuminate\Http\JsonResponse
     */
    private function processResponse($request, \FaithGen\SDK\Models\Pivots\MinistryUser $ministryUser, string $messagePrefix = 'Account logged successfully.')
    {
        $data = [
            'user' => new MinistryUser($ministryUser),
            'processing_image' => $request->has('image'),
        ];

        if (! $request->has('image')) {
            return $this->successResponse($messagePrefix, $data);
        } else {
            return $this->successResponse($messagePrefix.' We are uploading your picture now', $data);
        }
    }

    /**
     * Deletes a user account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserAccount()
    {
        auth('web')->user()->delete();

        return $this->successResponse('Account deleted successfully.');
    }

    /**
     * Fetches the complete user profile.
     *
     * @return MinistryUser
     */
    public function getUser()
    {
        $ministryUser = auth()->user()->ministryUsers()
            ->where('user_id', request()->headers->get('x-user-key'))
            ->first();

        MinistryUser::withoutWrapping();

        return new MinistryUser($ministryUser);
    }
}
