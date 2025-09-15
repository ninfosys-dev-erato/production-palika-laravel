<?php

namespace Src\GrantManagement\Livewire;

use Livewire\Component;
use App\Enums\Action;
use Src\GrantManagement\Models\CashGrant;
use Src\GrantManagement\Models\HelplessnessType;
use Src\Wards\Models\Ward;
use Illuminate\Support\Carbon;
use App\Traits\HelperDate;
use Src\GrantManagement\Exports\CashGrantExports;
use App\Facades\PdfFacade;
use Maatwebsite\Excel\Facades\Excel;
use App\Facades\GlobalFacade;
use Illuminate\Support\Facades\Auth;
use Src\Settings\Traits\AdminSettings;

class CashGrantReportForm extends Component
{
    use HelperDate, AdminSettings;

    public ?Action $action = Action::CREATE;

    public $wards = [];
    public $helplessnessType = [];

    public $selectedWards = [];
    public $selectedHelpnessType = [];
    public $start_date;
    public $end_date;

    public $filtered_datas = [];

    public function rules(): array
    {
        return [
            "start_date" => "required",
            "end_date" => "required",
            "selectedWards" => "nullable",
            "selectedHelpnessType" => "nullable",
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => __('grantmanagement::grantmanagement.start_date_is_required'),
            'end_date.required' => __('grantmanagement::grantmanagement.end_date_is_required'),
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'selectedWards.required' => 'Please select at least one ward.',
            'selectedHelpnessType.required' => 'Please select at least one type.',
        ];
    }

    public function mount(Action $action)
    {
        $this->action = $action;
        $this->helplessnessType = HelplessnessType::whereNull('deleted_at')->pluck('helplessness_type', 'id')->toArray();
        $this->wards = Ward::whereNull('deleted_at')->pluck('ward_name_ne', 'id')->toArray();
    }

    private function convertDevanagariToEnglish($input)
    {
        $nepali = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($nepali, $english, $input);
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

        $query = CashGrant::query()
            ->whereBetween('created_at', [$startDateAd, $endDateAd]);

        if (!empty($this->selectedHelpnessType)) {
            $query->whereIn('helplessness_type_id', (array) $this->selectedHelpnessType);
        }

        if (!empty($this->selectedWards)) {
            $query->whereIn('address', (array) $this->selectedWards);
        }

        $results = $query->with([
            'user',
            'ward',
            'getHelplessnessType'
        ])->get();

        $this->filtered_datas = $results;
    }

    public function export()
    {
        if (empty($this->filtered_datas)) {
            $this->errorToast(__('grantmanagement::grantmanagement.no_data_found'));
            return;
        }

        $exportFilePath = 'cash-grant-report.xlsx';
        return Excel::download(new CashGrantExports($this->filtered_datas), $exportFilePath);
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

        $html = view('GrantManagement::pdf.grantCash', compact('nepaliDate', 'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'reports', 'startDate', 'endDate'))->render();
        return redirect()->away(PdfFacade::saveAndStream(
            content: $html,
            file_path: config('grantmanagement.certificate', 'pdfs/grants/'),
            file_name: "grantmanagement-" . date('YmdHis'),
            disk: getStorageDisk('private'),
        ));
    }

    public function clearRelativeData()
    {

        $this->selectedWards = [];
        $this->selectedHelpnessType = [];
        $this->start_date = '';
        $this->end_date = '';

        $this->filtered_datas = [];
        $this->dispatch('clear-select2');
    }

    public function render()
    {
        return view("GrantManagement::livewire.cash-grants-report-form");
    }
}
