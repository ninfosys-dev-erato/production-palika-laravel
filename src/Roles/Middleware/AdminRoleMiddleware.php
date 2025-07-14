<?php

namespace Src\Roles\Middleware;

use App\Traits\SessionFlash;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRoleMiddleware
{
    use SessionFlash;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $role): Response
    {
        if(!Auth::user()->hasRole($role)) {
            // $this->errorFlash("You Need to be {$role} to access this resource", "Access Denied");
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }

}
