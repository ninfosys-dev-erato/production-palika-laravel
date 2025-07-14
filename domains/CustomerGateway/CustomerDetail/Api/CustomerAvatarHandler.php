<?php

namespace Domains\CustomerGateway\CustomerDetail\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerDetail\Services\CustomerDetailService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerAvatarHandler extends Controller
{

    use ApiStandardResponse;
    protected $customerDetailService;

    public function __construct(CustomerDetailService $customerDetailService)
    {
        $this->customerDetailService = $customerDetailService;
    }
    

    public function avatar(Request $request)
    {
        $request->validate([
                  'avatar' => ['required', 'string'],
        ]);
        $this->customerDetailService->avatar($request);
        return $this->generalSuccess(['message' => __('Photo set sucessfully'),]);

    }
}