<?php

namespace App\Providers;

use App\Guards\AdminGuard;
use App\Guards\ApiGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::extend('apiAuth', function ($app, $name, array $config) {
            $guard = new ApiGuard($app['request']);

            return $guard;
        });

        Auth::extend('adminAuth', function ($app, $name, array $config) {
            $guard = new AdminGuard($app['request']);

            return $guard;
        });
    }
}
