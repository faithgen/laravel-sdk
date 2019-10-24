<?php


namespace FaithGen\SDK\Services;


use FaithGen\SDK\Http\Resources\Ministry as MinistryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthService
{
    const REFRESH_TOKEN = 'refreshToken';

    public function attemptLogin(array $credentials = [])
    {
        if (!sizeof($credentials))
            $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials))
            return $this->validationFailed();


        return $this->proxy('password', [
            'username' => request()->email,
            'password' => request()->password
        ]);
    }

    public function attemptRefresh()
    {
        $refreshToken = request()->cookie(self::REFRESH_TOKEN);

        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    public function proxy($grantType, array $data = [])
    {

        $postData = array_merge($data, [
            'grant_type' => $grantType,
            'client_id' => env('CLIENT_ID', 2),
            'client_secret' => env('CLIENT_SECRET'),
            'scope' => '*',
        ]);

        $request = app()->make('request');
        $request->request->add($postData);

        $tokenRequest = Request::create(
            env('APP_URL') . '/oauth/token',
            'post'
        );

        $response = Route::dispatch($tokenRequest);

        if ($response->getStatusCode() == 200) {
            $results = json_decode($response->getContent());
        } else
            return $this->validationFailed();

        return [
            'ministry' => new MinistryResource(auth()->user()),
            'token' => [
                'access_token' => $results->access_token,
                'expires_in' => $results->expires_in,
            ]
        ];
    }

    public function authenticatedUser()
    {
        return new MinistryResource(auth()->user());
    }

    public function validationFailed()
    {
        abort(401, 'Invalid login credentials');
    }
}
