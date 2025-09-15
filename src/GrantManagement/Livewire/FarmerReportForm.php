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
use Src\GrantManagement\Models\Cooperative;
use Src\GrantManagement\Models\Enterprise;
use Src\GrantManagement\Models\Farmer;
use Src\GrantManagement\Models\FarmerGroup;
use Src\GrantManagement\Models\Group;
use Src\Settings\Traits\AdminSettings;
// errorToast

class FarmerReportForm extends Component
{
    use HelperDate, AdminSettings;

    public ?Action $action = Action::CREATE;
    public $start_date = '';
    public $end_date = '';
    public $province_id = [];
    public $district_id = [];
    public $local_body_id = [];
    public $ward_no = [];
    public $group_id = [];
    public $cooperative_id = [];
    public $enterprise_id = [];
    public $involved_farmer_id = [];

    public $filtered_datas = [];
    public $cooperatives = [];
    public $enterprises = [];
    public $proviences = [];
    public $wards = [];
    public $localBodies = [];
    public $districts = [];
    public $involvedGroups = [];
    public $involvedEnterprise = [];
    public $involvedCooperative = [];

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
        $this->cooperatives = Cooperative::whereNull('deleted_at')->pluck('name', 'id')->toArray();
        $this->enterprises = Enterprise::whereNull('deleted_at')->pluck('name', 'id')->toArray();

        $this->proviences = Province::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->districts = District::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->wards = Ward::whereNull('deleted_at')->pluck('ward_name_ne', 'id')->toArray();
        $this->localBodies = LocalBody::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->involvedGroups = Group::whereNull('deleted_at')->pluck('name', 'id')->toArray();
        $this->involvedEnterprise = Enterprise::whereNull('deleted_at')->pluck('name', 'id')->toArray();
        $this->involvedCooperative = Cooperative::whereNull('deleted_at')->pluck('name', 'id')->toArray();
    }

    public function showRelativeData()
    {
        $this->validate();

        $startDateAd = Carbon::parse($this->bsToAd($this->start_date));
        $endDateAd = Carbon::parse($this->bsToAd($this->end_date))->endOfDay();


        $query = Farmer::with([
            'province',
            'district',
            'localBody',
            'ward',
            'user',
            'groups',
            'cooperatives',
            'enterprises'
        ])
            ->whereBetween('created_at', [$startDateAd, $endDateAd]);

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

        if (!empty($this->involved_farmer_id)) {
            $query->whereHas('involvedFarmers', function ($q) {
                $q->whereIn('involved_farmer_id', $this->involved_farmer_id);
            });
        }

        if (!empty($this->group_id)) {
            $query->whereHas('groups', function ($q) {
                $q->whereIn('group_id', $this->group_id);
            });
        }

        if (!empty($this->cooperative_id)) {
            $query->whereHas('cooperatives', function ($q) {
                $q->whereIn('cooperative_id', $this->cooperative_id);
            });
        }

        if (!empty($this->enterprise_id)) {
            $query->whereHas('enterprises', function ($q) {
                $q->whereIn('enterprise_id', $this->enterprise_id);
            });
        }

        $this->filtered_datas = $query->get();
    }



    public function clearRelativeData()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->province_id = [];
        $this->district_id = [];
        $this->local_body_id = [];
        $this->ward_no = [];
        $this->group_id = [];
        $this->cooperative_id = [];
        $this->enterprise_id = [];
        $this->involved_farmer_id = [];
        $this->filtered_datas = [];
        $this->dispatch('clear-select2');
    }

    public function errorToast($message)
    {
        $this->dispatch('toast:error', message: $message);
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

        $html = view('GrantManagement::pdf.farmer', compact('nepaliDate', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports', 'startDate', 'endDate'))->render();
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

        $exportFilePath = 'farmer-report.xlsx';
        return Excel::download(new FarmerExports($this->filtered_datas), $exportFilePath);
    }

    public function render()
    {
        return view("GrantManagement::livewire.farmer-report-form");
    }
}
