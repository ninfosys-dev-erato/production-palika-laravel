<?php

namespace Src\GrantManagement\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\GrantManagement\Models\CashGrant;
use Src\GrantManagement\Models\Grant;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;

class GrantManagementDashboard extends Controller
{
    public function index(Request $request)
    {
        try {
            $currentFiscalYear = FiscalYear::first();

            $totalGrantCash = CashGrant::all();
            $Wards = Ward::all();
            

            $totalCashGrantsByWard = CashGrant::select('address as ward_id', DB::raw('SUM(cash) as total_cash'))
                ->whereNull('deleted_at')
                ->groupBy('address')
                ->with('ward') // optional if you define relationship
                ->get()
                ->map(function ($item) {
                    $ward = Ward::find($item->ward_id);
                    return [
                        'ward_id' => $item->ward_id,
                        'ward_name' => $ward?->display_name ?? 'Unknown Ward',
                        'total_cash' => $item->total_cash,
                    ];
                });

            // Get the total number of farmers, cooperatives, groups, and enterprises
            $TotalFarmers = DB::table('gms_farmers')
                ->whereNull('deleted_at')
                ->count();

            $TotalCooperatives = DB::table('gms_cooperatives')
                ->whereNull('deleted_at')
                ->count();

            $TotalGroups = DB::table('gms_groups')
                ->whereNull('deleted_at')
                ->count();

            $TotalEnterprises = DB::table('gms_enterprises')
                ->whereNull('deleted_at')
                ->count();

            // Get the grants for the current fiscal year
            $TotalGrants = Grant::where('fiscal_year_id', $currentFiscalYear->id)
                ->whereNull('deleted_at')
                ->count();

        } catch (\Exception $e) {
            // Handle the error and redirect
            return redirect()->route('admin.storey_details.index');
        }

        // dd($totalCashGrantsByWard);
        // Return the view with the updated data
        return view('GrantManagement::dashboard', compact(
            'TotalFarmers',
            'TotalCooperatives',
            'currentFiscalYear',
            'TotalGroups',
            'TotalEnterprises',
            'TotalGrants',  // Include total grants for the current fiscal year
            'totalCashGrantsByWard'
        ));
    }
}
