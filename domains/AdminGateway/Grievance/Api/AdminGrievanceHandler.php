<?php
namespace Domains\AdminGateway\Grievance\Api;

use App\Facades\GlobalFacade;
use App\Http\Controllers\Controller;
use Domains\AdminGateway\Grievance\Resources\AdminGrievanceDetailResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Grievance\Models\GrievanceDetail;

class AdminGrievanceHandler extends Controller{
    /**
     * @lrd:start
     * ### 🔍 Filtering
     *
     * | Parameter              | Description                       |
     * |------------------------|-----------------------------------|
     * | `filter[token]`        | Filter by token (exact match)     |
     * | `filter[name]`         | Filter by customer's name         |
     * | `filter[status]`        | Filter by status (exact match)     |
     * | `filter[mobile_no]`    | Filter by customer's mobile number |
     *
     * *Example:**
     * ```http
     * GET /api/grievances?filter[token]=GRV123
     * GET /api/grievances?filter[name]=John%20Doe
     * GET /api/grievances?filter[mobile_no]=9800000000
     * ```
     *
     * ### 🔃 Sorting
     *
     * You can sort results using the `sort` parameter:
     *
     * | Sort Field    | Description                |
     * |---------------|----------------------------|
     * | `created_at`  | Sort by creation date      |
     * | `updated_at`  | Sort by update date        |
     *
     * *Descending order:** Prefix with `-`
     *
     * *Examples:**
     * ```http
     * GET /api/grievances?sort=-created_at       // Newest first
     * GET /api/grievances?sort=updated_at        // Oldest updated first
     * ```
     *
     * ---
     * @lrd:end
 */
    public function listGrievance()
    {
        $user = Auth::user('api-user');

        // Start with Spatie Query Builder
        $query = QueryBuilder::for(GrievanceDetail::with([
            'roles',
            'grievanceType.branches',
            'grievanceDetail',
            'branch',
            'customer',
            'files',
            'histories',
        ]))
            ->allowedFilters([
                AllowedFilter::exact('token'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('name','customer.name'),
                AllowedFilter::exact('mobile_no','customer.mobile_no'),
            ])

            ->allowedIncludes([
                'roles',
                'grievanceType.branches',
                'grievanceDetail',
                'branch',
                'files',
                'histories',
            ])
            ->defaultSort('-gri_grievance_details.created_at')
            ->allowedSorts('created_at', 'updated_at') // Optional
            ->whereNull(['grievance_detail_id', 'gri_grievance_details.deleted_at']);

        // Super admin sees all
        if ($user->hasRole('super-admin')) {
            return AdminGrievanceDetailResource::collection(
                $query->paginate()
            );
        }

        // Apply user-specific filters
        $departmentIds = $user->departments?->pluck('id')->toArray() ?? [];
        $wardIds = $user->userWards()->pluck('ward')->toArray() ?? [];
        $roleIds = $user->roles()->pluck('id')->toArray() ?? [];

        $query->where(function ($q) use ($departmentIds, $wardIds, $roleIds) {

            // WARD-based grievances
            $q->where(function ($subQ) use ($departmentIds, $wardIds) {
                $subQ->where('gri_grievance_details.is_ward', true)
                    ->where(function ($innerQ) use ($departmentIds, $wardIds) {
                        $innerQ
                            ->whereIn('gri_grievance_details.ward_id', $wardIds)
                            ->orWhereHas('grievanceType.branches', function ($branchQ) use ($departmentIds) {
                                $branchQ->whereIn('mst_branches.id', $departmentIds);
                            })
                            ->orWhereIn('gri_grievance_details.branch_id', $departmentIds);
                    });
            });

            // NON-ward-based grievances
            $q->orWhere(function ($subQ) use ($departmentIds, $roleIds) {
                $subQ->where('gri_grievance_details.is_ward', false)
                    ->where(function ($innerQ) use ($departmentIds, $roleIds) {
                        $innerQ
                            ->whereHas('grievanceType.branches', function ($branchQ) use ($departmentIds) {
                                $branchQ->whereIn('mst_branches.id', $departmentIds);
                            })
                            ->orWhereIn('gri_grievance_details.branch_id', $departmentIds)
                            ->orWhereHas('roles', function ($roleQ) use ($roleIds) {
                                $roleQ->whereIn('roles.id', $roleIds);
                            });
                    });
            });
        });

        return AdminGrievanceDetailResource::collection(
            $query->paginate()->appends(request()->query())
        );
    }
    public function showGrievance(){}

    public function grievanceAction()
    {

    }
}