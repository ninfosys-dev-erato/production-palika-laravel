<?php

namespace Src\Ejalas\Service;


use Illuminate\Support\Facades\Route;
use Src\Ejalas\Enum\RouteName;

class CheckRouteAdminService
{

    // public static function isActive(string $routePattern, RouteName $from): bool
    // {
    //     return Route::is($routePattern) && request('from') == $from->value;
    // }
    public static function isActive($routePatterns, ?RouteName $from = null): bool
    {
        $patterns = is_array($routePatterns) ? $routePatterns : [$routePatterns];

        $routeMatches = false;
        foreach ($patterns as $pattern) {
            if (Route::is($pattern)) {
                $routeMatches = true;
                break;
            }
        }

        $fromMatches = is_null($from) || request('from') == $from->value;

        return $routeMatches && $fromMatches;
    }
}
