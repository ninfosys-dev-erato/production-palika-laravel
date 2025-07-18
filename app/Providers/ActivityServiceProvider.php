<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogLoginActivity;
use App\Listeners\LogLogoutActivity;
class ActivityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        Login::class => [LogLoginActivity::class],
        Logout::class => [LogLogoutActivity::class],
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
