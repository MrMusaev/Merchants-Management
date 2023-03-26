<?php

namespace App\Services\Auth;

use App\Constants\ErrorCodes;
use App\Exceptions\Custom\FrontEndException;
use App\Http\Data\Api\Auth\RegisterData;
use App\Http\Requests\Auth\ApiLoginRequest;
use App\Http\Requests\Backend\Common\Auth\LoginRequest;
use App\Http\Resources\User\UserDetailsResource;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Attempt to authenticate the request's credentials.
     *
     * @param ApiLoginRequest $request
     *
     * @return User
     * @throws ValidationException|FrontEndException
     */
    public function authenticate(ApiLoginRequest $request): User
    {
        $request->email = Str::lower($request->email);
        $this->ensureIsNotRateLimited($request);

        if (!Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->boolean('remember_me')
        )) {
            RateLimiter::hit($this->throttleKey($request));

            throw new FrontEndException(__('auth.failed'), ErrorCodes::AUTH_CREDENTIALS_FAILED);
        }

        RateLimiter::clear($this->throttleKey($request));
        return User::whereEmail($request->email)->firstOrFail();
    }

    public function registerUser(RegisterData $data): User
    {
        $user = User::create([
            'name' => $data->name,
            'email' => Str::lower($data->email),
            'password' => Hash::make($data->password)
        ]);
        // $organizer->assignRole($organizerRole);

        return $user;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @param ApiLoginRequest $request
     * @return void
     *
     * @throws ValidationException
     */
    private function ensureIsNotRateLimited(ApiLoginRequest $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages(
            [
                'email' => trans(
                    'auth.throttle', [
                        'seconds' => $seconds,
                        'minutes' => ceil($seconds / 60),
                    ]
                ),
            ]
        );
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @param ApiLoginRequest $request
     *
     * @return string
     */
    private function throttleKey(ApiLoginRequest $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
