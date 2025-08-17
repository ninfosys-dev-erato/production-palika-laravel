<?php

namespace Src\GrantManagement\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Src\GrantManagement\Controllers\GrantProgramAdminController;
use Src\GrantManagement\DTO\GrantProgramAdminDto;
use Src\GrantManagement\Models\GrantProgram;
use Src\GrantManagement\Service\GrantProgramAdminService;
use Livewire\Attributes\On;
use Src\Employees\Models\Branch;
use Src\GrantManagement\Enums\ForGrantsEnum;
use Src\GrantManagement\Models\GrantOffice;
use Src\GrantManagement\Models\GrantType;
use Src\Settings\Models\FiscalYear;
use Src\GrantManagement\Enums\MaritalStatus;
use Src\GrantManagement\Enums\DecisionTypeEnum;
use Illuminate\Support\Facades\DB;

class GrantProgramForm extends Component
{
    use SessionFlash;

    public ?GrantProgram $grantProgram;
    public ?Action $action = Action::CREATE;
    public $fiscalYears = [];
    public $GrantTypes = [];
    public $GrantingOrganizations = [];
    public $branches = [];
    public $forGrants = [];
    public $grantGiven;
    public $HoldTempForGrant = [];
    public $decisionTypes = [];

    public $toggleGrantSection;

    public function rules(): array
    {
        return [
            'grantProgram.grant_amount' => ['nullable'],
            'grantProgram.fiscal_year_id' => ['required'],
            'grantProgram.type_of_grant_id' => ['required'],
            'grantProgram.granting_organization_id' => ['required'],
            'grantProgram.branch_id' => ['required'],
            'grantProgram.program_name' => ['required'],
            'grantProgram.for_grant' => ['nullable'],
            'grantProgram.condition' => ['required'],
            'HoldTempForGrant' => ['nullable'],
            'grantProgram.grant_provided_quantity' => ['nullable'],
            'grantProgram.grant_provided' => ['nullable'],
            'grantProgram.grant_provided_type' => ['required'],
            'grantProgram.decision_type' => ['required'],
            'grantProgram.decision_date' => ['required'],

        ];
    }
    public function messages(): array
    {
        return [
            'grantProgram.grant_amount.required' => __('grantmanagement::grantmanagement.grant_amount_is_required'),
            'grantProgram.fiscal_year_id.required' => __('grantmanagement::grantmanagement.fiscal_year_id_is_required'),
            'grantProgram.type_of_grant_id.required' => __('grantmanagement::grantmanagement.type_of_grant_id_is_required'),
            'grantProgram.granting_organization_id.required' => __('grantmanagement::grantmanagement.granting_organization_id_is_required'),
            'grantProgram.branch_id.required' => __('grantmanagement::grantmanagement.branch_id_is_required'),
            'grantProgram.program_name.required' => __('grantmanagement::grantmanagement.program_name_is_required'),
            'grantProgram.for_grant.required' => __('grantmanagement::grantmanagement.for_grant_is_required'),
            'grantProgram.condition.required' => __('grantmanagement::grantmanagement.condition_is_required'),
            'grantGiven.required' => __('grantmanagement::grantmanagement.condition_is_required'),
            'grantProgram.grant_provided_type' => __('grantmanagement::grantmanagement.grant_provided_type_is_required'),
            'grantProgram.decision_type.required' => __('grantmanagement::grantmanagement.decision_type_is_required'),
            'grantProgram.decision_date.date' => __('grantmanagement::grantmanagement.decision_date_is_required'),
        ];
    }

    public function render()
    {
        return view("GrantManagement::livewire.grant-programs-form");
    }

    public function ToggleSection()
    {
        $this->toggleGrantSection = $this->grantProgram->grant_provided_type;
    }

    public function mount(GrantProgram $grantProgram, Action $action)
    {
        $this->grantProgram = $grantProgram;
        $this->action = $action;
        $this->fiscalYears = FiscalYear::whereNull('deleted_by')->get()->pluck('year', 'id')->toArray();
        // $this->fiscalYears = FiscalYear::all();
        // $this->GrantTypes = GrantType::all();
        $this->GrantTypes = GrantType::whereNull('deleted_by')->get()->pluck('title', 'id')->toArray();
        $this->GrantingOrganizations = GrantOffice::whereNull('deleted_by')->get()->pluck('office_name', 'id')->toArray();
        $this->forGrants = ForGrantsEnum::getValuesWithLabels();
        $this->decisionTypes = DecisionTypeEnum::getValuesWithLabels();
        // $this->branches = Branch::all();
        $this->branches = Branch::whereNull('deleted_by')->get()->pluck('title', 'id')->toArray();
    }

    public function updateSelectedForGrant($value)
    {
        $this->HoldTempForGrant = $value;
    }

    public function save()
    {
        $this->validate();
        $this->grantProgram->for_grant = $this->HoldTempForGrant;
        $dto = GrantProgramAdminDto::fromLiveWireModel($this->grantProgram);
        $service = new GrantProgramAdminService();

        try {
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('grantmanagement::grantmanagement.grant_program_created_successfully'));
                    return redirect()->route('admin.grant_programs.index');

                    break;
                case Action::UPDATE:
                    $service->update($this->grantProgram, $dto);
                    $this->successFlash(__('grantmanagement::grantmanagement.grant_program_updated_successfully'));
                    return redirect()->route('admin.grant_programs.index');

                    break;
                default:
                    return redirect()->route('admin.grant_programs.index');
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('grantmanagement::grantmanagement.an_error_occurred_during_operation_please_try_again_later'));
        }
    }
}
