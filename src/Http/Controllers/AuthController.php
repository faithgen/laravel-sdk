<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Http\Requests\Ministry\CreateRequest;
use FaithGen\SDK\Http\Requests\Ministry\ForgotPasswordRequest;
use FaithGen\SDK\Http\Requests\Ministry\LoginRequest;
use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Notifications\Ministry\AccountActivated;
use FaithGen\SDK\Notifications\Ministry\AccountCreated;
use FaithGen\SDK\Notifications\Ministry\ForgotPassword;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use InnoFlash\LaraStart\Services\AuthService;
use InnoFlash\LaraStart\Traits\APIResponses;

class AuthController extends Controller
{
    use AuthorizesRequests, APIResponses;
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * Injects the AuthService to handle logic on a separate file
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('welcome');
    }

    public function register(CreateRequest $request)
    {
        if (strcmp($request->password, $request->confirm_password) == 0) {
            $params = $request->validated();
            unset($params['confirm_password']);
            $ministry = new Ministry($params);
            try {
                $ministry->save();

                return $this->authService->attemptLogin();
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        } else {
            abort(500, 'Passwords did not match');
        }
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->attemptLogin();
    }

    public function activateAccount(Ministry $ministry, $code)
    {
        if (strcmp($ministry->activation->code, $code) == 0) {
            $activation = $ministry->activation;
            $activation->active = true;
            try {
                $activation->save();
                $ministry->notify(new AccountActivated($ministry));

                return redirect()->away(config('faithgen-sdk.ministries-server'));
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        } else {
            abort(500, 'Activation code is incorrect!');
        }

        return $ministry;
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $ministry = Ministry::whereEmail($request->email)->first();
        if ($ministry) {
            $ministry->notify(new ForgotPassword($ministry));

            return $this->successResponse('We have emailed you a reset password email, please follow it to to update your password');
        } else {
            abort(500, 'Account with email not found!');
        }
    }

    public function resendActivation()
    {
        try {
            auth()->user()->notify(new AccountCreated(auth()->user()));

            return $this->successResponse('We have sent you an activation email again, please check your email and activate this account');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function deleteAccount()
    {
        try {
            auth()->user()->delete();

            return $this->successResponse('Account has been deleted');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->user()->token()->revoke();

            return $this->successResponse('Logged out');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
