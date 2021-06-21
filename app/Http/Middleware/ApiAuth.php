<?php

namespace App\Http\Middleware;

use App\Traits\Token;
use Closure;
use Illuminate\Http\Request;

class ApiAuth
{
    use Token;

    protected string $token;

    public function __construct(Request $request)
    {
        $this->token = $request->header('Authorization') ?? '';
    }

    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $this->getPayLoad($this->token);

            // 验签是否正确
            $this->decodeJwt($this->token, \config('jwt.admin_secret'));
        } catch (\Throwable) {
            return \response()->json(status: 401);
        }

        return $next($request);
    }
}
