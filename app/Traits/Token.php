<?php

namespace App\Traits;

use Firebase\JWT\JWT;

trait Token
{
    private static object $payLoad;

    protected function getPayLoad(string $token): void
    {
        $tks = \explode('.', $token);

        self::$payLoad = 3 === \count($tks) ? JWT::jsonDecode(JWT::urlsafeB64Decode($tks[1])) : [];
    }

    protected function decodeJwt(string $token, string $secret): void
    {
        JWT::$leeway = \config('jwt.leeway');

        JWT::decode($token, $secret, ['HS256']);
    }
}
