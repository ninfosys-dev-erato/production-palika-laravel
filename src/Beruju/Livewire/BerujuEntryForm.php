<?php

namespace Src\Beruju\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Beruju\DTO\BerujuEntryDto;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Service\BerujuEntryService;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use Src\Beruju\Enums\BerujuAduitTypeEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;
use Src\Beruju\Enums\BerujuCurrencyTypeEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Src\Employees\Models\Branch;

class BerujuEntryForm extends Component
{
    use SessionFlash;

    public ?BerujuEntry $berujuEntry;
    public ?Action $action;
    public $fiscalYears = [];
    public $branches = [];
    public array $auditTypeOptions = [];
    public array $berujuCategoryOptions = [];
    public array $currencyTypeOptions = [];

    public function rules(): array
    {
        return [
            // Form fields from form.blade.php
            'berujuEntry.fiscal_year_id' => ['nullable', 'string'],
            'berujuEntry.audit_type' => ['nullable', 'string'],
            'berujuEntry.entry_date' => ['nullable', 'string'],
            'berujuEntry.reference_number' => ['nullable', 'string', 'max:255'],
            'berujuEntry.branch_id' => ['nullable', 'string'],
            'berujuEntry.project_id' => ['nullable', 'string'],
            'berujuEntry.beruju_category' => ['nullable', 'string'],
            'berujuEntry.sub_category_id' => ['nullable', 'string'],
            'berujuEntry.amount' => ['nullable', 'string'],
            'berujuEntry.currency_type' => ['nullable', 'string'],
            'berujuEntry.legal_provision' => ['nullable', 'string'],
            'berujuEntry.action_deadline' => ['nullable', 'string'],
            'berujuEntry.description' => ['nullable', 'string'],
            'berujuEntry.notes' => ['nullable', 'string'],
            // Additional fields
            'berujuEntry.status' => ['required', 'string'],
            'berujuEntry.submission_status' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'berujuEntry.status.required' => __('beruju::beruju.the_status_field_is_required'),
            'berujuEntry.submission_status.required' => __('beruju::beruju.the_submission_status_field_is_required'),
        ];
    }

    public function render()
    {
        return view("Beruju::livewire.form");
    }

    public function mount(BerujuEntry $berujuEntry, Action $action)
    {
        $this->berujuEntry = $berujuEntry;
        $this->action = $action;

        $this->loadEnumOptions();
        $this->fiscalYears = getFiscalYears()->pluck('year', 'id')->toArray();
        $this->branches = Branch::whereNull('deleted_at')->pluck('title', 'id')->toArray();
    }

    private function loadEnumOptions()
    {
        // Load audit type options
        $this->auditTypeOptions = BerujuAduitTypeEnum::getForWeb();

        // Load beruju category options
        $this->berujuCategoryOptions = BerujuCategoryEnum::getForWeb();

        // Load currency type options
        $this->currencyTypeOptions = BerujuCurrencyTypeEnum::getForWeb();
    }

    public function save()
    {
        $this->validate();

        $dto = BerujuEntryDto::fromLiveWireModel($this->berujuEntry);
        $service = new BerujuEntryService();

        DB::beginTransaction();
        try {
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    DB::commit();
                    $this->successFlash(__('beruju::beruju.beruju_created_successfully'));
                    return redirect()->route('admin.beruju.index');
                    break;

                case Action::UPDATE:
                    $service->update($this->berujuEntry, $dto);
                    DB::commit();
                    $this->successFlash(__('beruju::beruju.beruju_updated_successfully'));
                    return redirect()->route('admin.beruju.index');
                    break;

                default:
                    return $this->redirect(url()->previous());
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('beruju::beruju.something_went_wrong_while_saving'));
        }
    }
}
