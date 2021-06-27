<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class AdminRbac
{
    public function handle(Request $request, Closure $next): mixed
    {
        \dd(\md5(Str::replace('\\', '', Route::currentRouteAction())));

        return $next($request);
    }
}
