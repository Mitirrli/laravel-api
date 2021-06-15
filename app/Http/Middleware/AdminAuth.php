<?php

namespace App\Http\Middleware;

use App\Http\Admin\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AdminAuth
{
    public string $token = '';
    private static object $payLoad;
    private static $user = [];

    /**
     * TODO: 使用http状态码 403 替换 1999.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return void
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->token = $request->header('Authorization') ?? '';

        // 未登录提示 去登录
        if (empty($this->token)) {
            return \response()->output(code: 1999, message: '请登录');
        }

        try {
            $this->getPayLoad($this->token);

            // 验签是否正确
            $this->decodeJwt();
        } catch (\Throwable) {
            return \response()->output(code: 1999, message: '请登录');
        }

        return $next($request);
    }

    /**
     * * 获取用户信息.
     *
     * @return void
     */
    public static function user(): mixed
    {
        if (empty(self::$user)) {
            self::$user = User::find(self::$payLoad->uid);
        }

        return self::$user;
    }

    protected function getPayLoad(string $token): void
    {
        $tks = \explode('.', $token);

        self::$payLoad = 3 === \count($tks) ? JWT::jsonDecode(JWT::urlsafeB64Decode($tks[1])) : [];
    }

    protected function decodeJwt(): void
    {
        JWT::$leeway = \config('jwt.leeway');

        JWT::decode($this->token, \config('jwt.secret'), ['HS256']);
    }
}
