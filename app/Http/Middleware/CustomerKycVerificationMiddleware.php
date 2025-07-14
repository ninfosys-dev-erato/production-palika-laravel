<?php

namespace App\Http\Middleware;

use App\Traits\ApiStandardResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerKycVerificationMiddleware
{
    use ApiStandardResponse;

    public function handle(Request $request, Closure $next): Response
    {
        $customer = Auth::guard('api-customer')->user();

        if (is_null($customer->kyc_verified_at)) {
            return $this->generalFailure([
                'message' => "not-verified", // Do not change this message, 
                'status' => 'error'
            ], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
