<?php

namespace Src\BusinessRegistration\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\BusinessRenewal;
use Src\BusinessRegistration\Models\RegistrationCategory;
use Src\BusinessRegistration\Models\RegistrationType;

class BusinessRegistrationDashboardController extends Controller
{
    public function index()
    {
        try {
            [
                $registrationApplicationCount,
                $renewalApplicationCount,
                $registeredBusinessCount,
                $renewedBusinessCount,

            ] = Cache::remember('business-registration-dashboard-data', now()->addMinutes(5), function () {
                return Concurrency::run([
                    fn() => BusinessRegistration::whereNull('deleted_at')->count() ?? 0,
                    fn() => BusinessRenewal::whereNull('deleted_at')->count() ?? 0,
                    fn() => BusinessRegistration::whereNotNull('registration_date')
                        ->whereNotNull('registration_number')
                        ->whereNull('deleted_at')
                        ->count() ?? 0,
                    fn() => BusinessRenewal::whereNotNull('renew_date')
                        ->whereNull('deleted_at')
                        ->count() ?? 0,

                ]);
            });
        } catch (\Exception $e) {
            Cache::forget('business-registration-dashboard-data');
            return redirect()->route('admin.business-registration.index');
        }

        $registrationTypes = RegistrationType::withCount('businessRegistrations')->get();

        return view("BusinessRegistration::dashboard", [
            'registrationApplicationCount' => $registrationApplicationCount,
            'renewalApplicationCount' => $renewalApplicationCount,
            'registeredBusinessCount' => $registeredBusinessCount,
            'renewedBusinessCount' => $renewedBusinessCount,
            'registrationTypes' => $registrationTypes

        ]);
    }

    public function report()
    {
        return view("BusinessRegistration::report");
    }
    public function renewalReport()
    {
        return view("BusinessRegistration::renewal-report");
    }
}
