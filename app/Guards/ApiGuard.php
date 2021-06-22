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
     */
    public function user()
    {
        if (empty($this->token)) {
            return null;
        }

        return User::query()->where('uid', $this->getPayLoad($this->token)->uid)->first();
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
     * decode jwt for check.
     *
     * @return bool
     */
    public function check(): bool
    {
        $this->decodeJwt($this->token, \config('jwt.secret'));

        return true;
    }
}
