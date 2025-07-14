<?php

namespace Src\Customers\Livewire;  // Updated namespace to match your intended usage

use Livewire\Component;;
use Src\CustomerKyc\Model\CustomerKycVerificationLog;

class CustomerDetailKycVerificationLogs extends Component
{
    public $customerKycId;

    protected $listeners = ['kycStatusUpdated' => '$refresh']; // Listen for the event to refresh


    public function mount($customerKycId)
    {
        $this->customerKycId = $customerKycId;
    }

    public function render()
    {
        $kycLogs = CustomerKycVerificationLog::where('customer_id', $this->customerKycId)->orderBy('created_at','desc')->get();
        
        $groupedLogs = $kycLogs->groupBy(function ($log) {
            return $log->created_at->format('Y-m-d');
        });
        
        return view('Customers::livewire.customerDetail.kyc_verification_logs', [ 
            'groupedLogs' => $groupedLogs,
        ]);
        
    }
}