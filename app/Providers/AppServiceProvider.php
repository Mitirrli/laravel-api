<?php

namespace App\Providers;

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
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(\Laravel\Tinker\TinkerServiceProvider::class);
            $this->app->register(\Laravel\Sail\SailServiceProvider::class);
            $this->app->register(\NunoMaduro\Collision\Adapters\Laravel\CollisionServiceProvider::class);

            $this->app->register(\Illuminate\View\ViewServiceProvider::class);
            $this->app->register(\Facade\Ignition\IgnitionServiceProvider::class);
            $this->app->register(\Illuminate\Pagination\PaginationServiceProvider::class);
            $this->app->register(\Illuminate\Session\SessionServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
