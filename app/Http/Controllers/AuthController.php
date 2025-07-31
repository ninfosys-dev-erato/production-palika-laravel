<?php

namespace App\Http\Controllers;

use App\Enums\ActivityEvents;
use App\Facades\ActivityLogFacade;
use App\Facades\GlobalFacade;
use App\Facades\ImageServiceFacade;
use App\Http\Requests\RegisterCustomerRequest;
use App\Traits\HelperDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Src\Customers\Models\Customer;

class AuthController extends Controller
{
    use HelperDate;

    public function login()
    {
        if (\auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }
    public function showRegisterForm()
    {
        return view('admin.register'); 
    }

    public function register(RegisterCustomerRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $avatarName = ImageServiceFacade::compressAndStoreImage($request->file('avatar'), 'customer/avatar', getStorageDisk('public'));
        } else {
            $avatarName = null;
        }
         Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' => $data['mobile_no'],
            'avatar' => $avatarName,
            'password' =>  Hash::make($data['password']),
        ]);

        return redirect()->route('digital-service')->with('success', 'Registration successful');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            activity()
                ->event((ActivityEvents::USER_LOGIN)->value)
                ->log('User login from Web Portal');
            if(auth()->user()->userWards()->first()){
                GlobalFacade::ward(auth()->user()->userWards()->first()->ward);
            }
            return redirect()->intended(route('admin.dashboard'));
        } else {
            return back()->withErrors(['email' => 'the provided credentials do not match our records.']);
        }
    }

    public function logout(Request $request)
    {
        activity()
        ->event((ActivityEvents::USER_LOGOUT)->value)
        ->log('User log-out from Web Portal');
        auth('web')->logout();
        session()->regenerate(true);
        return redirect()->route('login');
    }

    public function customerLogin(Request $request)
    {
        $mobileNo = $this->convertNepaliToEnglish($request->mobile_no);
        $request->merge(['mobile_no' => $mobileNo]);
        $request->validate([
            'mobile_no' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('customer')->attempt(['mobile_no' => $request->mobile_no, 'password' => $request->password])) {
            ActivityLogFacade::logForCustomer();
            activity()
                ->event((ActivityEvents::CUSTOMER_LOGIN)->value)
                ->log('Customer logged in from Web Portal');
    
            return redirect()->intended(route('customer.dashboard'));
        } else {
            return back()->withErrors(['mobile_no' => "प्रदान गरिएको प्रमाणहरू हाम्रो रेकर्डसँग मेल खाँदैनन्।"]);
        }
    }

    public function customerLogout(Request $request)
    {
        ActivityLogFacade::logForCustomer();
        activity()
            ->event((ActivityEvents::CUSTOMER_LOGOUT)->value)
            ->log('Customer logout from Web Portal');
        auth('customer')->logout();
        session()->regenerate(true);
        
        return redirect()->route('digital-service');
    }

    function changePassword()
    {
        return view('Profile::customerChangePassword');
    }
}
