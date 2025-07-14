<?php

namespace Frontend\CustomerPortal\DigitalBoard\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\PopUp;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;
use Src\Employees\Models\Employee;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Src\Grievance\Models\GrievanceDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Pages\Model\Page;


class DigitalBoardController extends Controller
{

    public function index()
    {
        $citizenCharters = CitizenCharter::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->get();
        $employees = Employee::whereNull(['deleted_at','deleted_by'])->with('designation')->get();

        $employees = Employee::with('designation')
            ->whereNull(['deleted_at','deleted_by'])
            ->whereIn('type', ['temporary staff', 'permanent staff'])
            ->orderBy('position')
            ->get();

        $representatives = Employee::with('designation')
            ->whereNull(['deleted_at','deleted_by'])
            ->where('type', 'representative')
            ->orderBy('position')
            ->get();

        $programs = Program::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->get();
        $videos = Video::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->get();
        $notices = Notice::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->latest()->take(4)->get();
        $popupData = PopUp::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->latest()->first();
        return view('CustomerPortal.DigitalBoard::digital-board', compact(
            'citizenCharters',
            'employees',
            'representatives',
            'programs',
            'videos',
            'notices',
            'popupData'
        ));
    }
    public function showCharterDetail(int $id)
    {
        $charter = CitizenCharter::find($id);
        return view('CustomerPortal.DigitalBoard::citizen-charter-detail', compact('charter'));
    }

    public function showNotices()
    {
        return view('CustomerPortal.DigitalBoard::notice-list');
    }

    public function showNoticeDetail(int $id)
    {
        $notice = Notice::where('id', $id)->first();
        return view('CustomerPortal.DigitalBoard::notice-detail', compact('notice'));
    }

    public function showPrograms()
    {
        return view('CustomerPortal.DigitalBoard::program-list');
    }

    public function showProgramDetail(int $id)
    {
        $program = Program::where('id', $id)->first();
        return view('CustomerPortal.DigitalBoard::program-detail', compact('program'));
    }

    public function showEmployees()
    {
        $employees = Employee::with('designation')->whereNull(['deleted_at','deleted_by'])->get();
        return view('CustomerPortal.DigitalBoard::employee-list', compact('employees'));
    }

    public function showVideos()
    {
        return view('CustomerPortal.DigitalBoard::video-list');
    }

    public function showVideoDetail(int $id)
    {
        $video = Video::where('id', $id)->first();
        return view('CustomerPortal.DigitalBoard::video-detail', compact('video'));
    }

    public function searchEmployees(Request $request)
    {
        $query = $request->input('query');

        $employees = Employee::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('address', 'LIKE', '%' . $query . '%')
            ->with('designation')
            ->whereNull(['deleted_at','deleted_by'])
            ->get();

        return view('CustomerPortal.DigitalBoard::employee-list', compact('employees', 'query'));
    }

    public function changeLanguage(Request $request)
    {
        $language = $request->input('language', 'en');
        App::setLocale($language);
        Cookie::queue('language', $language, 60 * 24 * 365);

        logger(App::getLocale());

        return response()->json(['message' => 'Language changed successfully']);
    }

    public function wardWiseDB(int $wardId)
    {

        $citizenCharters = CitizenCharter::whereHas('wards', function ($query) use ($wardId) {
            $query->where('ward', $wardId)
                ->whereNull(['deleted_at','deleted_by']);
        })->get();

        $programs = Program::whereHas('wards', function ($query) use ($wardId) {
            $query->where('ward', $wardId)
                ->whereNull(['deleted_at','deleted_by']);
        })->get();

        $videos = Video::whereHas('wards', function ($query) use ($wardId) {
            $query->where('ward', $wardId)
                ->whereNull(['deleted_at','deleted_by']);
        })->get();

        $notices = Notice::whereHas('wards', function ($query) use ($wardId) {
            $query->where('ward', $wardId)
                ->whereNull(['deleted_at','deleted_by']);
        })->latest()->take(4)->get();

        $popupData = PopUp::whereHas('wards', function ($query) use ($wardId) {
            $query->where('ward', $wardId)
                ->whereNull(['deleted_at','deleted_by']);
        })->latest()->first();

        $representatives = Employee::with('designation')
            ->whereNull(['deleted_at','deleted_by'])
            ->where('type', 'representative')
            ->orderBy('position')
            ->get();

        $employees = Employee::with('designation')
            ->whereNull(['deleted_at','deleted_by'])
            ->whereIn('type', ['temporary staff', 'permanent staff'])
            ->orderBy('position')
            ->get();


        return view('CustomerPortal.DigitalBoard::digital-board', compact(
            'citizenCharters',
            'employees',
            'programs',
            'videos',
            'notices',
            'popupData',
            'representatives',
            'employees'
        ));
    }

    public function branchWiseDB($branch)
    {
        $citizenCharters = CitizenCharter::whereHas('branch', function ($query) use ($branch) {
            $query->whereRaw('TRIM(title_en) = ?', [$branch]);
            })
            ->where('can_show_on_admin', true)
            ->whereNull('deleted_at')
            ->whereNull('deleted_by')
            ->get();

        $employees = Employee::whereNull(['deleted_at','deleted_by'])->with('designation')->get();

        $employees = Employee::with('designation')
            ->whereNull(['deleted_at','deleted_by'])
            ->whereIn('type', ['temporary staff', 'permanent staff'])
            ->orderBy('position')
            ->get();

        $representatives = Employee::with('designation')
            ->whereNull(['deleted_at','deleted_by'])
            ->where('type', 'representative')
            ->orderBy('position')
            ->get();

        $programs = Program::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->get();
        $videos = Video::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->get();
        $notices = Notice::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->latest()->take(4)->get();
        $popupData = PopUp::where('can_show_on_admin', true)->whereNull(['deleted_at','deleted_by'])->latest()->first();
        return view('CustomerPortal.DigitalBoard::digital-board', compact(
            'citizenCharters',
            'employees',
            'representatives',
            'programs',
            'videos',
            'notices',
            'popupData'
        ));
    }
}
