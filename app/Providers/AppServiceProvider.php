<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register(): void
  {
    if ($this->app->environment('local')) {
      $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
      $this->app->register(\Laravel\Tinker\TinkerServiceProvider::class);
      $this->app->register(\Laravel\Sail\SailServiceProvider::class);
      $this->app->register(\NunoMaduro\Collision\Adapters\Laravel\CollisionServiceProvider::class);
      $this->app->register(\Facade\Ignition\IgnitionServiceProvider::class);
    }
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot(): void
  {
    if ($this->app->environment('local')) {
      //预防 N+1 问题
      Model::preventLazyLoading(!\app()->isProduction());
    }

    //统一的返回
    Response::macro('output', function (int $code = 0, string $message = 'ok', $data = []) {
      return \response()->json([
        'code' => $code,
        'message' => $message,
        'data' => $data,
      ], options: \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES);
    });
  }
}
