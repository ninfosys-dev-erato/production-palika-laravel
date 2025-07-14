<?php

namespace Src\Employees\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Livewire\Attributes\On;
use Src\Employees\DTO\BranchAdminDto;
use Src\Employees\Models\Branch;
use Src\Employees\Service\BranchAdminService;
use Src\FiscalYears\DTO\FiscalYearAdminDto;
use Src\FiscalYears\Service\FiscalYearAdminService;
use AllowDynamicProperties;

#[AllowDynamicProperties] class BranchForm extends Component
{
    use SessionFlash;

    public ?Branch $branch;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'branch.title' => ['required'],
            'branch.title_en' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'branch.title.required' => __('employees::employees.the_branch_title_is_required'),
            'branch.title_en.required' => __('employees::employees.the_branch_title_in_english_is_required')
        ];
    }

    public function render()
    {
        return view("Employees::livewire.branch.form");
    }

    public function mount(Branch $branch, Action $action): void
    {
        $this->branch = $branch;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = BranchAdminDto::fromLiveWireModel($this->branch);
            $service = new BranchAdminService();
            switch ($this->action) {

                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('employees::employees.branch_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->branch, $dto);
                    $this->successFlash(__('employees::employees.branch_updated_successfully'));
                    break;
            }
            $this->dispatch('close-modal');
            return redirect()->route('admin.employee.branch.index');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash(__('employees::employees.something_went_wrong_while_saving_') . $e->getMessage());
        }
    }
}
