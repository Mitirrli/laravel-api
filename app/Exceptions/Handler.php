<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Wujunze\DingTalkException\DingTalkExceptionHelper;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        BusinessException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @return void
     */
    public function register(): void
    {
        $this->reportable(function (\Throwable $e): void {
            // 非本地调试环境 通知到钉钉
            if ('local' !== \config('app.env')) {
                DingTalkExceptionHelper::notify($e);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, \Throwable $e): \Symfony\Component\HttpFoundation\Response
    {
        if ($e instanceof ValidationException) {
            $errors = $e->errors();
            $firstError = \reset($errors);

            return new Response($firstError[0], 422);
        }

        return parent::render($request, $e);
    }
}
