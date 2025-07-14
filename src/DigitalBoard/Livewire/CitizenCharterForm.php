<?php

namespace Src\DigitalBoard\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Src\DigitalBoard\DTO\CitizenCharterAdminDto;
use Src\DigitalBoard\Models\CitizenCharter;
use Src\DigitalBoard\Service\CitizenCharterAdminService;
use Src\Employees\Models\Branch;

class CitizenCharterForm extends Component
{
    use SessionFlash;

    public ?CitizenCharter $citizenCharter;
    public ?Action $action;

    public bool $canShowOnAdmin = false;
    public array $wards = [];
    public array $branches = [];
    public array $selectedWards = [];

    public function rules(): array
    {
        return [
            'citizenCharter.branch_id' => ['sometimes', 'nullable'],
            'citizenCharter.service' => ['required'],
            'citizenCharter.required_document' => ['required'],
            'citizenCharter.amount' => ['sometimes', 'nullable'],
            'citizenCharter.time' => ['required'],
            'citizenCharter.responsible_person' => ['sometimes', 'nullable'],
        ];
    }

   


    public function render()
    {
        return view("DigitalBoard::livewire.citizen-charter.form");
    }

    public function mount(CitizenCharter $citizenCharter, Action $action)
    {
        $this->citizenCharter = $citizenCharter;
        $this->action = $action;
        $this->wards = getWardsArray();
        $this->branches = Branch::pluck('title', 'id')->toArray();

        if ($citizenCharter->exists) {
            $this->canShowOnAdmin = $citizenCharter->can_show_on_admin ?? false;
            $this->selectedWards = $citizenCharter->wards()?->pluck('ward')->toArray() ?? [];
        }
    }

    public function save()
    {
        $this->validate();

        $this->citizenCharter->can_show_on_admin = $this->canShowOnAdmin;

        $dto = CitizenCharterAdminDto::fromLiveWireModel($this->citizenCharter);
        $service = new CitizenCharterAdminService();

        DB::beginTransaction();

        try {
            switch ($this->action) {
                case Action::CREATE:
                    $citizenCharter = $service->store($dto);
                    $service->storeCitizenCharterWard($citizenCharter, $this->selectedWards);
                    DB::commit();

                    $this->successFlash(__("Citizen Charter Created Successfully"));
                    return redirect()->route('admin.digital_board.citizen_charters.index');
                case Action::UPDATE:
                    $citizenCharter = $service->update($this->citizenCharter, $dto);
                    $service->storeCitizenCharterWard($citizenCharter, $this->selectedWards);
                    DB::commit();

                    $this->successFlash(__("Citizen Charter Updated Successfully"));
                    return redirect()->route('admin.digital_board.citizen_charters.index');
                    break;
                default:
                    return redirect()->route('admin.digital_board.citizen_charters.index');
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('digitalboard::digitalboard.an_error_occurred_during_operation_please_try_again_later'));
        }
    }

    public function messages(): array
    {
        return [
            'citizenCharter.service.required' => __('digitalboard::digitalboard.the_service_field_is_required'),
            'citizenCharter.required_document.required' => __('digitalboard::digitalboard.the_required_document_field_is_required'),
            'citizenCharter.amount.sometimes' => __('digitalboard::digitalboard.the_amount_field_is_optional'),
            'citizenCharter.time.required' => __('digitalboard::digitalboard.the_time_field_is_required'),
            'citizenCharter.responsible_person.sometimes' => __('digitalboard::digitalboard.the_responsible_person_field_is_optional'),
            'citizenCharter.branch_id.nullable' => __('digitalboard::digitalboard.the_branch_field_is_nullable_and_can_be_empty_if_not_applicable'),
            'citizenCharter.service.string' => __('digitalboard::digitalboard.the_service_must_be_a_string'),
            'citizenCharter.required_document.string' => __('digitalboard::digitalboard.the_required_document_must_be_a_string'),
            'citizenCharter.amount.numeric' => __('digitalboard::digitalboard.the_amount_must_be_a_number'),
            'citizenCharter.time.string' => __('digitalboard::digitalboard.the_time_must_be_a_string'),
            'citizenCharter.responsible_person.string' => __('digitalboard::digitalboard.the_responsible_person_must_be_a_string'),
        ];
    }
}
