<?php

namespace Src\Grievance\Controllers;

use App\Enums\Action;
use App\Facades\FileTrackingFacade;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\SessionFlash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Grievance\Models\GrievanceDetail;

class GrievanceDetailController extends Controller implements HasMiddleware
{
    use SessionFlash;

    public static function middleware()
    {
        return [
            new Middleware('permission:grievance_detail_access', only: ['index'])
        ];
    }

    function index(Request $request)
    {
        return view('Grievance::grievanceDetail-index');
    }

    public function create(Request $request)
    {
        $action = Action::CREATE;
        $admin = true;
        return view('Grievance::grievanceDetail-form', compact(['action', 'admin']));
    }

    public function show(int $id)
    {
        $grievanceDetail = GrievanceDetail::with([
            'customer',
            'grievanceType.departments',
            'branch',
            'branches',
            'files'
            ])
            ->findOrFail($id);
            $branchTitle = $grievanceDetail->branches->pluck('title');
            $departmentTitles = $grievanceDetail->grievanceType?->departments->pluck('title')->toArray();
            $branchTitles = collect($branchTitle)
                ->merge($departmentTitles)
                ->unique()
                ->sort()
                ->values();

        $users = User::pluck('name', 'id')->toArray();
        return view('Grievance::grievanceDetail-show', compact('grievanceDetail', 'users', 'branchTitles'));
    }

    public function register(int $id)
    {
        $grievanceDetail = GrievanceDetail::with('customer')->where('id', $id)->first();
        FileTrackingFacade::recordFile($grievanceDetail, register: $register = true);
        return redirect()->route('admin.grievance.grievanceDetail.show', $id);
        
    }
}
