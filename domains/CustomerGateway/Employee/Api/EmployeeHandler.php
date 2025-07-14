<?php

namespace Domains\CustomerGateway\Employee\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Employee\Services\DomainEmployeeService;
use Illuminate\Http\Request;
use Domains\CustomerGateway\Employee\Resources\EmployeeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeHandler extends Controller
{
    use ApiStandardResponse;
    protected $domainEmployeeService;

    public function __construct(DomainEmployeeService $domainEmployeeService)
    {
        $this->domainEmployeeService = $domainEmployeeService;
    }
    
    /**
     * @lrd:start
     *
     * ### ✅ Filters (Query Params)
     * Use these to refine results:
     *
     * - `phone` → Filter by number
     * - `name` → Filter by employee name
     * - `type` → Filter by type(permanent_staff, temporary_staff, representative)
     * - `ward_no` → Filter by employee ward
     * - `address` → Filter by employee address
     * - `gender` → Filter by employee gender
     *
     * *Example:**
     * *GET /api/v1/employees?filter[name]=John&filter[type]=representative*
     *
     *
     * ### ✅ Sorting
     * Sort results by `name`, 'email', `created_at`, 'position' 'type':
     * GET /api/v1/employees?sort=position
     * @lrd:end
     */
    public function show(Request $request): AnonymousResourceCollection
    {
        $employees = $this->domainEmployeeService->show(); 
        return EmployeeResource::collection($employees);
    }
}