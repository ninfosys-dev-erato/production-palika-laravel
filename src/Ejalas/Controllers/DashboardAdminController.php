<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\Party;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:complaint_registrations view')->only('index');
        //$this->middleware('permission:complaint_registrations edit')->only('edit');
        //$this->middleware('permission:complaint_registrations create')->only('create');
    }
    public function dashboard()
    {
        $complaints = ComplaintRegistration::whereNull('deleted_at')->get();

        $totalComplaint = $complaints->count();
        $totalPendingComplaint = $complaints->whereNull('status')->count();
        $totalRegisteredComplaint = $complaints->where('status', true)->count();
        $totalRejectedComplaint = $complaints->whereStrict('status', false)->count();

        $totalParties = Party::whereNull('deleted_at')->count();
        $wardWiseComplaintCount = ComplaintRegistration::whereNull('deleted_at')
            ->whereNotNull('ward_no')
            ->groupBy('ward_no')
            ->selectRaw('ward_no, count(*) as complaint_count')
            ->get();
        // $wardWiseComplaintCount = DB::table('jms_complaint_registrations as c')
        //     ->join('complaint_party as cp', 'c.id', '=', 'cp.complaint_id')
        //     ->join('jms_parties as p', 'cp.party_id', '=', 'p.id')
        //     ->where('c.status', true)
        //     ->whereNull('c.deleted_at')
        //     ->whereNull('p.deleted_at')
        //     ->select('p.permanent_ward_id as ward', DB::raw('COUNT(DISTINCT c.id) as total'))
        //     ->groupBy('p.permanent_ward_id')
        //     ->orderBy('p.permanent_ward_id')
        //     ->get();
        return view('Ejalas::dashboard', compact('totalComplaint', 'totalPendingComplaint', 'totalRegisteredComplaint', 'totalRejectedComplaint', 'totalParties', 'wardWiseComplaintCount'));
    }
}
