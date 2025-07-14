<?php

namespace App\Http\Controllers;

use App\Enums\ActivityEvents;
use App\Facades\ActivityLogFacade;
use App\Traits\HelperDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Ebps\Enums\OrganizationStatusEnum;
use Src\Ebps\Models\OrganizationUser;

class OrganizationController extends Controller
{

    use HelperDate;
 
    public function login()
    {
        return view('organization.login');
    }

    public function organizationRegister()
    {
        return view('organization.register');

    }
    public function organizationLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $organizationUser = OrganizationUser::where('email', $request->email)
            ->with('organization')
            ->first();

        if (!$organizationUser) {
            return back()->withErrors(['email' => "प्रदान गरिएको प्रमाणहरू हाम्रो रेकर्डसँग मेल खाँदैनन्।"]);
        }

        if (!$organizationUser->organization) {
            return back()->withErrors(['email' => "संस्था/परामर्शदाता सम्बन्धी जानकारी उपलब्ध छैन।"]);
        }

        $status = $organizationUser->organization->status;

        if ($status === OrganizationStatusEnum::PENDING) {
            return back()->withErrors(['email' => "अनुरोध हाल समीक्षा अन्तर्गत छ।"]);
        }

        if ($status === OrganizationStatusEnum::REJECTED) {
            return back()->withErrors(['email' => "अनुरोध अस्वीकृत भएको छ। कृपया तपाईंको इमेल जाँच गर्नुहोस्।"]);
        }

        if (Auth::guard('organization')->attempt(['email' => $request->email, 'password' => $request->password])) {
            ActivityLogFacade::logForCustomer();
            activity()
                ->event(ActivityEvents::BUSINESS_LOGIN->value)
                ->log('Business logged in from Web Portal');

            return redirect()->intended(route('organization.dashboard'));
        }

        return back()->withErrors(['email' => "प्रदान गरिएको प्रमाणहरू हाम्रो रेकर्डसँग मेल खाँदैनन्।"]);
    }
    

    function changeOrganizationPassword()
    {
        return view('Profile::changeOrganizationPassword');
    }

    public function organizationLogout(Request $request)
    {
        activity()
        ->event((ActivityEvents::BUSINESS_LOGOUT)->value)
        ->log('User log-out from Business Portal');
        auth('organization')->logout();
        session()->regenerate(true);
        return redirect()->route('organization-login');
    }
}
