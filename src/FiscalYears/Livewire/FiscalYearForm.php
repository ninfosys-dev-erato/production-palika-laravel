<?php

namespace Src\FiscalYears\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\FiscalYears\DTO\FiscalYearAdminDto;
use Src\FiscalYears\Models\FiscalYear;
use Src\FiscalYears\Service\FiscalYearAdminService;

class FiscalYearForm extends Component
{
    use SessionFlash;

    public ?FiscalYear $fiscalYear;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'fiscalYear.year' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'fiscalYear.year.required' => __('fiscalyears::fiscalyears.the_fiscal_year_field_is_required'),
        ];
    }


    public function render()
    {
        return view("FiscalYears::livewire.form");
    }

    public function mount(FiscalYear $fiscalYear, Action $action): void
    {
        $this->fiscalYear = $fiscalYear;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = FiscalYearAdminDto::fromLiveWireModel($this->fiscalYear);
            $service = new FiscalYearAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('fiscalyears::fiscalyears.fiscal_year_created_successfully'));
                    break;
                case Action::UPDATE:
                    $service->update($this->fiscalYear, $dto);
                    $this->successFlash(__('fiscalyears::fiscalyears.fiscal_year_updated_successfully'));
                    break;
            }
            return redirect()->route('admin.setting.fiscal-years.index');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
}
