<?php

namespace App\Http\Middleware;

use App\Facades\ActivityLogFacade;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customer = Auth::guard('api-customer')->user();
        if ($customer && $customer->language_preference->value) {
            App::setLocale($customer->language_preference->value);
        } else {
            App::setLocale('en');
        }
        return $next($request);
    }
}
