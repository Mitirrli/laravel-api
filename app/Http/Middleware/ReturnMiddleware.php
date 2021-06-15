<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReturnMiddleware
{
    public function handle(Request $request, Closure $next): JsonResponse | Response
    {
        $response = $next($request);

        // 异常 或 状态码不为 200 则继续传递到下层
        if ($response->exception || 200 !== $response->getStatusCode()) {
            return $response;
        }

        // JsonResponse 需要带上 header
        return \response()->json($response->getData('data'), headers: $response->headers->all());
    }
}
