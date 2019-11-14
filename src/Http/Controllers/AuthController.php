<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Helpers\Helper;
use FaithGen\SDK\Models\Ministry;
use App\Http\Controllers\Controller;
use InnoFlash\LaraStart\Services\AuthService;
use FaithGen\SDK\Http\Requests\Ministry\LoginRequest;
use FaithGen\SDK\Http\Requests\Ministry\CreateRequest;
use FaithGen\SDK\Notifications\Ministry\AccountCreated;
use FaithGen\SDK\Notifications\Ministry\ForgotPassword;
use FaithGen\SDK\Notifications\Ministry\AccountActivated;
use FaithGen\SDK\Http\Requests\Ministry\ForgotPasswordRequest;

class AuthController extends Controller
{

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

    function index()
    {
        return view('welcome');
    }

    function register(CreateRequest $request)
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
        } else
            abort(500, 'Passwords did not match');
    }

    function login(LoginRequest $request)
    {
        return $this->authService->attemptLogin();
    }

    function activateAccount(Ministry $ministry, $code)
    {
        if (strcmp($ministry->activation->code, $code) == 0) {
            $activation = $ministry->activation;
            $activation->active = true;
            try {
                $activation->save();
                $ministry->notify(new AccountActivated($ministry));
                return redirect()->away(config('faithgen-sdk.ministriesDomain'));
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        } else
            abort(500, 'Activation code is incorrect!');
        return $ministry;
    }

    function forgotPassword(ForgotPasswordRequest $request)
    {
        $ministry = Ministry::whereEmail($request->email)->first();
        if ($ministry) {
            $ministry->notify(new ForgotPassword($ministry));
            return $this->successResponse('We have emailed you a reset password email, please follow it to to update your password');
        } else
            abort(500, 'Account with email not found!');
    }

    function resendActivation()
    {
        try {
            auth()->user()->notify(new AccountCreated(auth()->user()));
            return $this->successResponse('We have sent you an activation email again, please check your email and activate this account');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    function deleteAccount()
    {
        try {
            auth()->user()->delete();
            return $this->successResponse('Account has been deleted');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    function logout()
    {
        try {
            auth()->user()->token()->revoke();
            return $this->successResponse('Logged out');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
