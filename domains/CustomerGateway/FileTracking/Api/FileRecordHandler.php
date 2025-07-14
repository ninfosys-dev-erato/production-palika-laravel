<?php

namespace Domains\CustomerGateway\FileTracking\Api;

use App\Http\Controllers\Controller;
use Domains\CustomerGateway\FileTracking\Resources\FileRecordResource;
use Domains\CustomerGateway\FileTracking\Services\DomainFileRecordService;

class FileRecordHandler extends Controller
{
    public $domainFileRecordService;
    public function __construct()
    {
        $this->domainFileRecordService = new DomainFileRecordService();
    }

    /**
     * @lrd:start
     *
     * ### ✅ Filters (Query Params)
     * Use these to refine results:
     *
     * - `reg_no` → Filter by registration number
     * - `applicant_name` → Filter by applicant name
     * - `document_level` → Filter by document level
     * - `sender_medium` → Filter by sender method (Enum)
     * - `record_type=darta` → Inward records (`is_chalani=false`)
     * - `record_type=chalani` → Outward records (`is_chalani=true`)
     *
     * *Example:**
     * *GET /api/file-records?filter[applicant_name]=John&filter[record_type]=chalani*
     *
     *
     * ### ✅ Sorting
     * Sort results by `reg_no` or `created_at`:
     * GET /api/file-records?sort=-created_at
     * @lrd:end
     */
    public function searchRecords()
    {
        $records = $this->domainFileRecordService->search(request()->user('api-customer'));
        return FileRecordResource::collection($records);
    }
}