<?php

namespace Src\GrantManagement\Livewire;

use App\Traits\HelperDate;
use Livewire\Component;
use App\Enums\Action;
use Src\GrantManagement\Models\CashGrant;
use Src\GrantManagement\Models\HelplessnessType;
use Src\Provinces\Models\Province;
use Src\Wards\Models\Ward;
use Illuminate\Support\Carbon;
use Src\Employees\Models\Branch;
use Src\FiscalYears\Models\FiscalYear;
use Src\GrantManagement\Models\GrantOffice;
use Src\GrantManagement\Models\GrantType;
use Maatwebsite\Excel\Facades\Excel;
use Src\GrantManagement\Exports\GrantProgramExports;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use Illuminate\Support\Facades\Auth;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\GrantManagement\Exports\FarmerExports;
use Src\GrantManagement\Exports\GroupExports;
use Src\GrantManagement\Models\Cooperative;
use Src\GrantManagement\Models\Enterprise;
use Src\GrantManagement\Models\Farmer;
use Src\GrantManagement\Models\FarmerGroup;
use Src\GrantManagement\Models\Group;
use Src\Settings\Traits\AdminSettings;

class GroupReportForm extends Component
{
    use HelperDate, AdminSettings;

    public ?Action $action = Action::CREATE;
    public $start_date = '';
    public $end_date = '';
    public $province_id = [];
    public $district_id = [];
    public $local_body_id = [];
    public $ward_no = [];
    public $selected_farmer = [];

    public $filtered_datas = [];
    public $proviences = [];
    public $wards = [];
    public $localBodies = [];
    public $districts = [];
    public $involvedFarmer = [];

    public function rules(): array
    {
        return [
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => __('grantmanagement::grantmanagement.start_date_is_required'),
            'end_date.required' => __('grantmanagement::grantmanagement.end_date_is_required')
        ];
    }

    public function mount(Action $action)
    {
        $this->action = $action;

        $this->proviences = Province::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->districts = District::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->wards = Ward::whereNull('deleted_at')->pluck('ward_name_ne', 'id')->toArray();
        $this->localBodies = LocalBody::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->involvedFarmer = Farmer::with('user')
            ->whereNull('deleted_at')
            ->get()
            ->mapWithKeys(function ($farmer) {
                return [$farmer->id => optional($farmer->user)->name ?? 'N/A'];
            })
            ->toArray();
    }

    public function showRelativeData()
    {
        $this->validate();

        $startDateAd = Carbon::parse($this->bsToAd($this->start_date));
        $endDateAd = Carbon::parse($this->bsToAd($this->end_date))->endOfDay();

        $query = Group::with([
            'province',
            'district',
            'localBody',
            'ward',
            'farmers'
        ])
            ->whereBetween('created_at', [$startDateAd, $endDateAd])
            ->whereNull('deleted_at');

        if (!empty($this->province_id)) {
            $query->whereIn('province_id', $this->province_id);
        }

        if (!empty($this->district_id)) {
            $query->whereIn('district_id', $this->district_id);
        }

        if (!empty($this->local_body_id)) {
            $query->whereIn('local_body_id', $this->local_body_id);
        }

        if (!empty($this->ward_no)) {
            $query->whereIn('ward_no', $this->ward_no);
        }
        if (!empty($this->selected_farmer)) {
            $query->whereHas('farmers', function ($q) {
                $q->whereIn('farmer_id', $this->selected_farmer);
            });
        }


        $this->filtered_datas = $query->get();
    }


    public function errorToast($message)
    {
        $this->dispatch('toast:error', message: $message);
    }


    public function clearRelativeData()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->province_id = [];
        $this->district_id = [];
        $this->local_body_id = [];
        $this->ward_no = [];
        $this->filtered_datas = [];
        $this->selected_farmer = [];
        $this->dispatch('clear-select2');
    }

    public function downloadPdf()
    {
        $reports = $this->filtered_datas;
        $startDate = $this->start_date;
        $endDate = $this->end_date;
        if ($reports == null) {
            $this->errorToast(__('grantmanagement::grantmanagement.no_data_found'));
            return;
        }
        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = $this->getConstant('palika-name');
        $palika_logo = $this->getConstant('palika-logo');
        $palika_campaign_logo = $this->getConstant('palika-campaign-logo');

        $address = $this->getConstant('palika-district') . ', ' . $this->getConstant('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
        $nepaliDate = $this->convertEnglishToNepali($this->adToBs(now()->format('Y-m-d')));

        // foreach ($reports as $registerToken) {  //converted english date to nepali
        //     $registerToken->created_at_bs = replaceNumbers(
        //         $this->adToBs($registerToken->created_at->format('Y-m-d')),
        //         true
        //     );
        // }

        $html = view('GrantManagement::pdf.group', compact('nepaliDate', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports', 'startDate', 'endDate'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('grantmanagement.certificate', 'pdfs/grants/'),
            file_name: "grantmanagement-" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }

    public function export()
    {
        if (empty($this->filtered_datas)) {
            $this->errorToast(__('grantmanagement::grantmanagement.no_data_found'));
            return;
        }

        $exportFilePath = 'group-report.xlsx';
        return Excel::download(new GroupExports($this->filtered_datas), $exportFilePath);
    }

    public function render()
    {
        return view("GrantManagement::livewire.group-report-form");
    }
}
