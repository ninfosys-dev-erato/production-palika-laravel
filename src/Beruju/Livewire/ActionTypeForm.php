<?php

namespace Src\Beruju\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Beruju\DTO\ActionTypeAdminDto;
use Src\Beruju\Models\ActionType;
use Src\Beruju\Models\SubCategory;
use Src\Beruju\Service\ActionTypeAdminService;
use Livewire\Attributes\On;

class ActionTypeForm extends Component
{
    use SessionFlash;

    public ?ActionType $actionType;
    public ?Action $action = Action::CREATE;
    public $subCategories;

    public function rules(): array
    {
        return [
            'actionType.name_eng' => ['nullable'],
            'actionType.name_nep' => ['required'],
            'actionType.sub_category_id' => ['nullable'],
            'actionType.remarks' => ['nullable'],
            'actionType.form_id' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'actionType.name_nep.required' => __('beruju::beruju.name_nep_required'),
            'actionType.sub_category_id.nullable' => __('beruju::beruju.sub_category_id_exists'),
            'actionType.remarks.nullable' => __('beruju::beruju.no_remarks'),
            'actionType.form_id.nullable' => __('beruju::beruju.form_id_exists'),
        ];
    }

    public function render()
    {
        return view("Beruju::livewire.action-type-form");
    }

    public function mount(ActionType $actionType = null, Action $action = Action::CREATE)
    {
        $this->actionType = $actionType ?? new ActionType();
        $this->action = $action;
        $this->subCategories = SubCategory::whereNull('deleted_at')->pluck('name_eng', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = ActionTypeAdminDto::fromLiveWireModel($this->actionType);
        $service = new ActionTypeAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('beruju::beruju.action_type_created'));
                $this->dispatch('close-modal');
                break;
            case Action::UPDATE:
                $service->update($this->actionType, $dto);
                $this->successFlash(__('beruju::beruju.action_type_updated'));
                $this->dispatch('close-modal');
                break;
            default:
                return redirect()->route('admin.beruju.action-types.index');
                break;
        }
    }

    #[On('edit-action-type')]
    public function actionType(ActionType $actionType)
    {
        $this->actionType = $actionType;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }

    #[On('reset-form')]
    public function resetActionType()
    {
        $this->reset(['actionType', 'action']);
        $this->actionType = new ActionType();
    }
}
