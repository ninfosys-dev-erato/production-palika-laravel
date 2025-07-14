<?php

namespace Src\Permissions\Middleware;

use App\Traits\SessionFlash;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermissionMiddleware
{
    use SessionFlash;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $permission): Response
    {
        if(!can($permission)) {
            // $this->warningFlash("You Dont Have Permission {$permission} to Access this resource", "Access Denied");
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
