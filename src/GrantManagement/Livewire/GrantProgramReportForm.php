<?php

namespace Src\GrantManagement\Livewire;

use App\Traits\HelperDate;
use Livewire\Component;
use App\Enums\Action;
use Src\GrantManagement\Models\CashGrant;
use Src\GrantManagement\Models\HelplessnessType;
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
use Src\Settings\Traits\AdminSettings;

class GrantProgramReportForm extends Component
{
    use HelperDate, AdminSettings;

    public ?Action $action = Action::CREATE;
    public $start_date = '';
    public $end_date = '';
    public $selectedFiscalYear = [];
    public $selectedGrantType = [];
    public $selectedBranchType = [];
    public $selectedGrantGivingOrg = [];
    public $filtered_datas = [];
    public $fiscalYear = [];
    public $grantType = [];
    public $branch = [];
    public $grantOffice = [];
    public $grant_delivered_type = '';

    public function rules(): array
    {
        return [
            'start_date' => 'required',
            'end_date' => 'required',
            'selectedFiscalYear' => 'nullable',
            'selectedGrantType' => 'nullable',
            'selectedBranchType' => 'nullable',
            'selectedGrantGivingOrg' => 'nullable',
            'grant_delivered_type' => 'nullable',
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
        $this->fiscalYear = FiscalYear::whereNull('deleted_at')->pluck('year', 'id')->toArray();
        $this->grantType = GrantType::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->branch = Branch::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->grantOffice = GrantOffice::whereNull('deleted_at')->pluck('office_name', 'id')->toArray();
    }

    public function errorToast($message)
    {
        $this->dispatch('toast:error', message: $message);
    }


    public function showRelativeData()
    {
        $this->validate();
        $startDateAd = Carbon::parse($this->bsToAd($this->start_date));
        $endDateAd = Carbon::parse($this->bsToAd($this->end_date))->endOfDay();

        $query = \Src\GrantManagement\Models\GrantProgram::query();

        // Filter by created_at range
        $query->whereBetween('created_at', [$startDateAd, $endDateAd]);

        // Apply filters if selected
        if (!empty($this->selectedFiscalYear)) {
            $query->whereIn('fiscal_year_id', (array) $this->selectedFiscalYear);
        }

        if (!empty($this->selectedGrantType)) {
            $query->whereIn('type_of_grant_id', (array) $this->selectedGrantType);
        }

        if (!empty($this->selectedBranchType)) {
            $query->whereIn('branch_id', (array) $this->selectedBranchType);
        }

        if (!empty($this->selectedGrantGivingOrg)) {
            $query->whereIn('granting_organization_id', (array) $this->selectedGrantGivingOrg);
        }

        if ($this->grant_delivered_type) {
            $query->whereIn('grant_provided_type', $this->grant_delivered_type);
        }

        $query->with([
            'fiscalYear',
            'grantType',
            'branch',
            'grantingOrganization'
        ]);

        return $this->filtered_datas = $query->get();
    }

    public function export()
    {
        if (empty($this->filtered_datas)) {
            $this->errorToast(__('grantmanagement::grantmanagement.no_data_found'));
            return;
        }

        $exportFilePath = 'grant-program-report.xlsx';
        return Excel::download(new GrantProgramExports($this->filtered_datas), $exportFilePath);
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

        $html = view('GrantManagement::pdf.grantProgram', compact('nepaliDate', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports', 'startDate', 'endDate'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('grantmanagement.certificate', 'pdfs/grants/'),
            file_name: "grantmanagement-" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }

    public function clearRelativeData()
    {
        $this->start_date = '';
        $this->end_date = '';

        $this->selectedFiscalYear = [];
        $this->selectedGrantType = [];
        $this->selectedBranchType = [];
        $this->selectedGrantGivingOrg = [];

        $this->filtered_datas = [];
        $this->dispatch('clear-select2');
    }


    public function render()
    {
        return view("GrantManagement::livewire.grant-program-report-form");
    }
}
