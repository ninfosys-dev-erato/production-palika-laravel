<?php

namespace Frontend\CustomerPortal\Grievance\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceDetail;

class CustomerGrievanceController extends Controller
{
    public function index()
    {
        $registeredCount = GrievanceDetail::all()->count();

        $processingCount = GrievanceDetail::whereIn('status', [GrievanceStatusEnum::INVESTIGATING, GrievanceStatusEnum::REPLIED])->count();

        $solvedCount = GrievanceDetail::where('status', GrievanceStatusEnum::CLOSED)->count();
       
        $myCount = GrievanceDetail::where('customer_id', Auth::guard('customer')->id())->count();

        return view('CustomerPortal.Grievance::customerGrievanceDetail-index', compact([
            'registeredCount',
            'processingCount',
            'solvedCount',
            'myCount'
        ]));

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $action = Action::CREATE;
        $admin = false;
        return view('CustomerPortal.Grievance::grievanceDetail-form')->with(compact(['action', 'admin']));
    }

    /**
     * Display the specified resource.
     */
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
        $branchTitles = $grievanceDetail->branches->pluck('title');

        $users = User::pluck('name', 'id')->toArray();
        return view('CustomerPortal.Grievance::customerGrievanceDetail-show', compact('grievanceDetail', 'users', 'branchTitles'));
  
    }
}