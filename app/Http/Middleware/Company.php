<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * 仅公司支持访问的中间件.
 */
class Company
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (\gethostbyname('qjdata.tpddns.cn') === $request->getClientIp()) {
            return $next($request);
        }

        if ('local' === \config('app.env')) {
            return $next($request);
        }

        return \response()->json(status: 401);
    }
}
