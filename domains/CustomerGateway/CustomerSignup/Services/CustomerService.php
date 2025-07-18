<?php

namespace Domains\CustomerGateway\CustomerSignup\Services;

use App\Enums\OtpPurpose;
use Src\Customers\Models\Otp;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Src\Customers\Models\Customer;
use Carbon\Carbon;

class CustomerService
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function generateAndSendOtp(string $mobile_no, OtpPurpose $purpose, $otpValidityDuration = 5): string
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $otpRecord = Otp::updateOrCreate(['mobile_no' => $mobile_no],
            [
                'otp' => $otp,
                'purpose' => $purpose->value,
                'validity' => Carbon::now()->addMinutes($otpValidityDuration),
                'verification_flag' => false,
            ]
        );

        $message = "Your OTP code is: $otp";
        $this->smsService->sendSms($mobile_no, $message);

        return encrypt($otpRecord->id);
    }

    public function verifyOtp(array $data): array
    {
        $customerOtp = Otp::where('id', $data['token'])->first();

        if (!$customerOtp) {
            return ['success' => false, 'message' => 'OTP not found.'];
        }

        if ($customerOtp->otp === $data['otp']) {
            $customerOtp->verified_at = now();
            $customerOtp->verification_flag = true;
            $customerOtp->save();

            return ['success' => true, 'message' => 'OTP verified successfully!'];
        }

        return ['success' => false, 'message' => 'Invalid OTP.'];
    }

    public function setPassword($data)
    {
        $isVerified = Otp::where('mobile_no', $data->mobile_no)
            ->where('verification_flag', true)
            ->exists();

        if (!$isVerified) {
            return ['success' => false, 'message' => 'Mobile number is not verified.'];
        }

        $user = Customer::updateOrCreate(
            ['mobile_no' => $data->mobile_no],
            [
                'password' => $data->password,
                'expo_push_token' => $data->expo_push_token,
                'notification_preference' => json_encode(['mail' => true, 'sms' => false, 'expo' => true])
            ]
        );

        return ['success' => true, 'message' => 'Password set sucessfully.'];
    }

    public function logout(): array
    {
        $customer = Auth::guard('api-customer')->user();

        if (!$customer) {
            return [
                'success' => false,
                'message' => 'No authenticated user found.',
            ];
        }

        foreach ($customer->tokens as $token) {
            $token->revoke();
        }

        return [
            'success' => true,
            'message' => 'Successfully logged out.',
        ];
    }

    public function setLangauge($data): array
    {
        $customer = Auth::guard('api-customer')->user();

        $customer = Customer::updateOrCreate(
            ['id' => $customer->id],
            ['language_preference' => $data->language_preference]
        );

        if ($customer->language_preference->value === 'en') {
            $messageKey = $customer->wasRecentlyCreated ? 'Language preference has been set to English.' : 'Language preference has been updated to English.';
        } else {
            $messageKey = $customer->wasRecentlyCreated ? 'नेपाली भाषा चयन गरिएको छ।' : ' नेपाली भाषा अद्यावधिक गरिएको छ।';
        }
        
        return ['success' => true, 'message' => $messageKey];
    }

    public function setNotification(array $data): void
    {
        $customer = Auth::guard('api-customer')->user();

        $notificationPreferenceJson = json_encode($data['notification_preference']);

        $updateData = ['notification_preference' => $notificationPreferenceJson];
        if (isset($data['expo_push_token'])) {
            $updateData['expo_push_token'] = $data['expo_push_token'];
        }
        $customer = Customer::updateOrCreate(
            ['id' => $customer->id],
            $updateData
        );

    }
}
