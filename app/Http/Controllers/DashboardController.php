<?php

namespace App\Http\Controllers;

use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Src\Committees\Models\CommitteeType;
use Src\Customers\Models\Customer;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Models\Notice;
use Src\DigitalBoard\Models\PopUp;
use Src\DigitalBoard\Models\Program;
use Src\DigitalBoard\Models\Video;
use Src\Employees\Models\Branch;
use Src\Employees\Models\Employee;
use Src\Grievance\Models\GrievanceDetail;
use Src\Meetings\Models\Meeting;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;
use Src\Settings\Models\Form;
use Src\TaskTracking\Models\Task;
use Src\FileTracking\Models\FileRecord;
use Src\Wards\Models\Ward;
use App\Traits\HelperTemplate;
use App\Traits\MapApplyTrait;

class DashboardController extends Controller
{

    use HelperTemplate, MapApplyTrait;
    protected $smsProvider;

    public function __construct(SmsService $smsProvider)
    {
        $this->smsProvider = $smsProvider;
    }

    public function __invoke()
    {
        try {

            [
                $userCount,
                $employees,
                $grievances,
                $recommendationCount,
                $meetingCount,
                $customerCount,
                $meetingChart,
                $recommendationChart,
                $noticeCount,
                $videoCount,
                $programCount,
                $popUpCount,
                $citizenCharterCount,
                $runningTaskCount,
                $chalaniCount,
                $dartaCount,
                $wardCount,
                $branchCount,
            ] = Cache::remember('dashboard_data', now()->addMinutes(5), function () {
                // Execute queries sequentially instead of using Concurrency::run()
                $userCount = User::all()->count() ?? 0;
                $employeeCount = Employee::whereNull('deleted_at')->whereNull('deleted_by')->get() ?? 0;
                $grievanceCount = GrievanceDetail::whereNull('deleted_at')->get() ?? 0;
                $applyRecommendationCount = ApplyRecommendation::count() ?? 0;
                $meetingCount = Meeting::count() ?? 0;
                $customerCount = Customer::count() ?? 0;
                $meetingsByCommittee = CommitteeType::withCount('meetings')->latest()->get()->pluck('meetings_count', 'name')->toArray() ?? [];
                $recommendationsByType = Recommendation::withCount('applyRecommendations')
                    ->get()
                    ->pluck('apply_recommendations_count', 'title')->toArray() ?? [];
                $noticeCount = Notice::whereNull('deleted_at')
                    ->count() ?? 0;
                $videoCount = Video::whereNull('deleted_at')
                    ->count() ?? 0;
                $programCount = Program::whereNull('deleted_at')
                    ->count() ?? 0;
                $popUpCount = PopUp::whereNull('deleted_at')
                    ->count() ?? 0;
                $citizenCharterCount = CitizenCharter::whereNull('deleted_at')
                    ->count() ?? 0;
                $runningTaskCount = Task::whereIn('status', ['todo', 'inprogress'])->count() ?? 0;
                $chalaniCount = FileRecord::where('is_chalani', true)->count() ?? 0;
                $dartaCount = FileRecord::where('is_chalani', false)->whereNotNull('reg_no')->where('reg_no', '<>', '')->count() ?? 0;
                $wardCount = Ward::count() ?? 0;
                $branchCount = Branch::count() ?? 0;

                return [
                    $userCount,
                    $employeeCount,
                    $grievanceCount,
                    $applyRecommendationCount,
                    $meetingCount,
                    $customerCount,
                    $meetingsByCommittee,
                    $recommendationsByType,
                    $noticeCount,
                    $videoCount,
                    $programCount,
                    $popUpCount,
                    $citizenCharterCount,
                    $runningTaskCount,
                    $chalaniCount,
                    $dartaCount,
                    $wardCount,
                    $branchCount,
                ];
            });
        } catch (\Exception $e) {
            Cache::forget('dashboard_data');

            return redirect()->route('admin.dashboard');
        }

        $availableCredits = Cache::remember('available_credits', now()->addMinutes(5), function () {
            return $this->smsProvider->creditsAvailable();
        });
        $employeeCount = $employees->count();
        $grievanceCount = $grievances->count();
        $grievanceChart = Cache::remember('grievance_chart', now()->addMinutes(5), function () use ($grievances) {
            return $grievances->groupBy('status')->map(function ($item) {
                return $item->count();
            });
        });
        $employeeChart = Cache::remember('employee_chart', now()->addMinutes(5), function () use ($employees) {
            return $employees->groupBy('type')->map(function ($item) {
                return $item->count();
            });
        });

        return view('admin.dashboard', compact([
            'userCount',
            'employeeCount',
            'grievanceCount',
            'meetingCount',
            'recommendationCount',
            'customerCount',
            'meetingChart',
            'grievanceChart',
            'employeeChart',
            'recommendationChart',
            'availableCredits',
            'noticeCount',
            'videoCount',
            'programCount',
            'popUpCount',
            'citizenCharterCount',
            'runningTaskCount',
            'chalaniCount',
            'dartaCount',
            'wardCount',
            'branchCount'
        ]));
    }

      function template($formId)
    {
        $form = Form::where('id', $formId)->first();
        $formStyle = $form->style ?? '';

        return view('Ebps::template')->with(compact('form', 'formStyle'));
    }

    public function print( $formId)
    {
        
         try {
            $form = Form::findOrFail($formId);
            $html = $form->template;

            $letterHeadHtml = $this->getLetterHeader(
            ward_no: $form->ward_no ?? null,
            date: now()->format('Y-m-d'),
            reg_no: $form->registration_number ?? '1',
            is_darta: true,
            fiscal_year: getSetting('fiscal-year') ?? ''
            );

    
            $html = str_replace('{{global.letter-head}}', $letterHeadHtml, $html);


            $fileName = "map.pdf";
            $url = PdfFacade::saveAndStream(
                content: $html,
                file_path: config('src.Recommendation.recommendation.certificate'),
                file_name: $fileName,
                disk: getStorageDisk('private'),
                styles:$form?->styles ?? ""
            );
           
                return redirect()->away($url);
          
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }


      
}
