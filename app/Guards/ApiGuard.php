<?php

namespace App\Guards;

use App\Traits\Token;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Qjdata\User\Models\User;

class ApiGuard implements Guard
{
    use GuardHelpers;
    use Token;

    protected string $token;

    public function __construct(Request $request)
    {
        if (\is_array($request->header('Authorization'))) {
            $this->token = '';
        } else {
            $this->token = $request->header('Authorization') ?? '';
        }
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        if (!$this->hasUser()) {
            if (null === $this->id()) {
                return null;
            }
            $this->user = User::where('uid', $this->id())->first();
        }

        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        if ('' === $this->token) {
            return null;
        }

        return $this->getPayLoad($this->token)->uid;
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     *
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        try {
            $this->decodeJwt($this->token, \config('jwt.secret'));

            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        try {
            $this->decodeJwt($this->token, \config('jwt.secret'));

            return true;
        } catch (\Throwable) {
            return false;
        }
    }
}
