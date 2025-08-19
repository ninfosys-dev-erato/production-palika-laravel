<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Symfony\Component\HttpFoundation\Response;

class BusinessRegistrationOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id'); // or 'registration' if that's the param
        $registration = BusinessRegistration::with('applicants')->findOrFail($id);

        if (Auth::guard('customer')->check()) {
            $user = Auth::guard('customer')->user();

            $owns = $registration->applicants()->where(function ($q) use ($user) {
                $q->where('email', $user->email)
                    ->orWhere('phone', $user->mobile_no);
            })->exists();

            if (!$owns) {
                abort(403);
            }
        }

        return $next($request);
    }
}
