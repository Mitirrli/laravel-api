<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!Auth::guard()->check()) {
            return \response()->json(status: 401);
        }

        return $next($request);
    }
}
