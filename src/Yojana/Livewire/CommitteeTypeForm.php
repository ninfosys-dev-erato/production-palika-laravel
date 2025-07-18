<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Src\Yojana\DTO\CommitteeTypeAdminDto;
use Src\Yojana\Models\CommitteeType;
use Src\Yojana\Service\CommitteeTypeAdminService;
use Livewire\Attributes\On;


class CommitteeTypeForm extends Component
{
    use SessionFlash;

    public ?CommitteeType $committeeType;
    public ?Action $action = action::CREATE;

    public function rules(): array
    {
        return [
            'committeeType.name_en' => ['nullable', 'string', 'max:255'],
            'committeeType.code' => ['nullable', 'string', 'max:255'],
            'committeeType.name' => ['required', 'string', 'max:255'],
            // 'committeeType.committee_no' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'committeeType.name.required' => __('yojana::yojana.the_committee_name_is_required'),
            'committeeType.name.string' => __('yojana::yojana.the_committee_name_must_be_a_string'),
            'committeeType.name.max' => __('yojana::yojana.the_committee_name_must_not_exceed_255_characters'),
            'committeeType.committee_no.required' => __('yojana::yojana.the_committee_number_is_required'),
            'committeeType.committee_no.integer' => __('yojana::yojana.the_committee_number_must_be_an_integer'),
            'committeeType.committee_no.min' => __('yojana::yojana.the_committee_number_must_be_at_least_1'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.committee-types.form");
    }

    public function mount(CommitteeType $committeeType, Action $action)
    {
        $this->committeeType = $committeeType;
        $this->action = $action;
    }

    public function save()
    {
        try {
            $this->validate();
            $dto = CommitteeTypeAdminDto::fromLiveWireModel($this->committeeType);
            $service = new CommitteeTypeAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('yojana::yojana.committee_type_created_successfully'));
                    // return redirect()->route('admin.committee-types.index');
                    $this->resetForm();
                    break;
                case Action::UPDATE:
                    $service->update($this->committeeType, $dto);
                    $this->successFlash(__('yojana::yojana.committee_type_updated_successfully'));
                    // return redirect()->route('admin.committee-types.index');
                    $this->resetForm();
                    break;
                default:
                    return redirect()->route('admin.committee-types.index');
                    break;
            }

            $this->dispatch('close-modal');
        } catch (ValidationException $e) {
//            dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());

        } catch (\Exception $e) {
//            dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());

        }
    }

    #[On('edit-committee-type')]
    public function editCommitteeType(CommitteeType $committeeType)
    {
        $this->committeeType = $committeeType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    private function resetForm()
    {
        $this->reset(['committeeType', 'action']);
        $this->committeeType = new CommitteeType();
    }
    #[On('reset-form')]
    public function resetCommitteeType()
    {
        $this->resetForm();
    }


}
