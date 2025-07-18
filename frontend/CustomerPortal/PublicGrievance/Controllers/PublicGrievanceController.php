<?php

namespace Frontend\CustomerPortal\PublicGrievance\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Cache;
use Src\Grievance\Models\GrievanceDetail;

class PublicGrievanceController extends Controller
{
    use SessionFlash;

    public function index()
    {
        $grievances = GrievanceDetail::where('is_public', true)
            ->with('branch', 'customer', 'grievanceType')
            ->where('is_visible_to_public', true)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('CustomerPortal.PublicGrievance::public-grievance', compact('grievances'));

    }

    // $lock = Cache::lock('public_grivance' . $_SERVER['REMOTE_ADDR'], 10);
    // if ($lock->get()) {
    //     $response = $this->service->verifyOtp($validatedData['mobile_number'],$validatedData['otp']);
    //     $lock->release();
    //     return OnboardingOtpVerificationResponse::fromServiceResponse($response);
    // } else {
    //     return $this->lockElseHandler();
    // }
    public function apply()
    {
    //     $ipAddress = $_SERVER['REMOTE_ADDR'];
    //     $cacheKey = 'public_grievance_' . $ipAddress;

    // $requestCount = Cache::get($cacheKey, 0);

    // if ($requestCount >= 3) {
    //     return response()->json(['message' => 'You have reached the daily limit for submitting grievances.'], 429);
    // }

    // $lock = Cache::lock($cacheKey . '_lock', 10);

    
    // if ($lock->get()) {
    //     try {
    //         Cache::put($cacheKey, $requestCount + 1, now()->addDay());

    //         return redirect()->back()->with('success', 'Grievance submitted successfully.');
    //     } finally {
    //         $lock->release();
    //     }
    // } else {
    //     return response()->json(['message' => 'Too many requests. Please wait a few seconds and try again.'], 429);
    // }
        return view('CustomerPortal.PublicGrievance::apply-grievance');

    }
}