<?php

namespace App\Http\Middleware;

use App\Traits\Token;
use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    use Token;

    protected string $token;

    public function __construct(Request $request)
    {
        $this->token = $request->header('Authorization') ?? '';
    }

    public function handle(Request $request, Closure $next): mixed
    {
        if (!\auth('admin')->check()) {
            return \response()->json(status: 401);
        }

        return $next($request);
    }
}
