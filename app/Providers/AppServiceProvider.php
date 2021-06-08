<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
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
    }
}
