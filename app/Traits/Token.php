<?php

namespace App\Traits;

use Firebase\JWT\JWT;
use Str;

trait Token
{
    protected function getPayLoad(string $token): object
    {
        return JWT::jsonDecode(JWT::urlsafeB64Decode(Str::of($token)->between('.', '.')));
    }

    protected function decodeJwt(string $token, string $secret): void
    {
        JWT::$leeway = \config('jwt.leeway');

        JWT::decode($token, $secret, ['HS256']);
    }
}
