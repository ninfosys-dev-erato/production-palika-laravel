<?php

namespace Frontend\CustomerPortal\Home\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\HelperDate;
use Illuminate\Http\Request;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\PopUp;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;
use Src\Employees\Models\Employee;
use Src\Grievance\Models\GrievanceDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Pages\Models\Page;


class HomeController extends Controller
{
    use HelperDate;
    public function index(Request $request)
    {
        $grievanceData = Cache::remember('grievance_dashboard_data', now()->addMinutes(5), function () {
            // Execute queries sequentially instead of using Concurrency::run()
            $grievanceCount = GrievanceDetail::whereNull('deleted_at')->count();
            $grievancesInvestigatingCount = GrievanceDetail::where('status', GrievanceStatusEnum::INVESTIGATING)->count();
            $grievancesClosedCount = GrievanceDetail::where('status', GrievanceStatusEnum::CLOSED)->count();
            $services = Page::where('slug', 'service')->value('content');
            
            return [$grievanceCount, $grievancesInvestigatingCount, $grievancesClosedCount, $services];
        });

        [$grievanceCount, $grievancesInvestigatingCount, $grievancesClosedCount, $services] = $grievanceData;

        $citizenCharters = CitizenCharter::where('can_show_on_admin', true)->whereNull('deleted_at')->get();
        $employees = Employee::whereNull('deleted_at')->with('designation')->get();
        $programs = Program::where('can_show_on_admin', true)->whereNull('deleted_at')->get();
        $videos = Video::where('can_show_on_admin', true)->whereNull('deleted_at')->get();
        $notices = Notice::where('can_show_on_admin', true)->get();
        $popupData = PopUp::where('can_show_on_admin', true)->latest()->first();

        $digitalBoardPath = base_path('frontend/CustomerPortal/DigitalBoard');

        $hasDigitalBoard = Cache::remember('has_digital_board_directory', now()->addMinutes(5), function () use ($digitalBoardPath) {
            return is_dir($digitalBoardPath);
        });

        return view('CustomerPortal.Home::home', [
            'grievanceCount' => $grievanceCount,
            'grievancesInvestigatingCount' => $grievancesInvestigatingCount,
            'grievancesClosedCount' => $grievancesClosedCount,
            'services' => $services,
        ]);
        // }
    }


    public function grievance(Request $request)
    {
        $grievances = GrievanceDetail::where('is_public', true)
            ->with('branch', 'customer')
            ->where('is_visible_to_public', true)
            ->paginate(15);

        return view('CustomerPortal.Home::grievanceDetail-list', compact('grievances'));
    }
    public function tokenFeedback(Request $request)
    {
        $action = Action::CREATE;
        return view('CustomerPortal.Home::token-feedback', compact('action'));
    }
}
