<?php

namespace App\Providers;

use App\Models\Passport\Client;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Models\Passport\RefreshToken;
use App\Models\Passport\Token;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Src\Permissions\Models\Permission;

class PassportCustomConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Disable Routes and enable password grant
        Passport::enablePasswordGrant();
        Passport::ignoreRoutes();
        Passport::useTokenModel(Token::class);
        Passport::useClientModel(Client::class);
        Passport::$ignoreCsrfToken = true;
        Passport::useRefreshTokenModel(RefreshToken::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Passport::tokensCan(
            Permission::all()->pluck('name')->mapWithKeys(fn($perm) => [$perm => ucfirst(str_replace('_', ' ', $perm))])->toArray()
        );
        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'hasTokenPermission')) {
                return $user->hasTokenPermission($ability) ?: null;
            }
        });
    }
}
