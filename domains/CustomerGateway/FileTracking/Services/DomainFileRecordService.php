<?php

namespace Domains\CustomerGateway\FileTracking\Services;

use App\Services\FileTrackingService;
use FontLib\TrueType\Collection;
use Src\Customers\Models\Customer;
use Src\FileTracking\Service\FileRecordService;

class DomainFileRecordService
{
    public $fileRecordService;
    public function __construct()
    {
        $this->fileRecordService = new FileRecordService();
    }

    public function search(Customer $customer)
    {
        return $this->fileRecordService->search()
            ->where('applicant_mobile_no',$customer->mobile_no)
            ->orWhereMorphedTo('sender',$customer)
            ->paginate()
            ->appends(request()->query());
    }
}