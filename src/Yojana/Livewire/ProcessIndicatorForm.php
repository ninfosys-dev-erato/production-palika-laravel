<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ProcessIndicatorAdminDto;
use Src\Yojana\Models\ProcessIndicator;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\ProcessIndicatorAdminService;
use Livewire\Attributes\On;

class ProcessIndicatorForm extends Component
{
    use SessionFlash;

    public ?ProcessIndicator $processIndicator;
    public ?Action $action = Action::CREATE;
    public $units;

    public function rules(): array
    {
        return [
            'processIndicator.title' => ['required'],
            'processIndicator.unit_id' => ['required'],
            'processIndicator.code' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'processIndicator.title.required' => __('yojana::yojana.title_is_required'),
            'processIndicator.unit_id.required' => __('yojana::yojana.unit_id_is_required'),
            'processIndicator.code.required' => __('yojana::yojana.code_is_required'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.process-indicators.form");
    }

    public function mount(ProcessIndicator $processIndicator, Action $action)
    {
        $this->processIndicator = $processIndicator;
        $this->action = $action;
        $this->units = Unit::whereNull('deleted_at')->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = ProcessIndicatorAdminDto::fromLiveWireModel($this->processIndicator);
        $service = new ProcessIndicatorAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.process_indicator_created_successfully'));
//                return redirect()->route('admin.process_indicators.index');
                break;
            case Action::UPDATE:
                $service->update($this->processIndicator, $dto);
                $this->successFlash(__('yojana::yojana.process_indicator_updated_successfully'));
//                return redirect()->route('admin.process_indicators.index');
                break;
            default:
//                return redirect()->route('admin.process_indicators.index');
                break;
        }
        $this->dispatch('close-modal', id: 'processIndicatorModal');
        $this->resetProcessIndicator();
        $this->dispatch('refresh-process-indicator');
    }


    #[On('edit-processIndicator')]
    public function editSubRegion(ProcessIndicator $processIndicator)
    {
        $this->processIndicator = $processIndicator;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetProcessIndicator()
    {
        $this->reset(['processIndicator', 'action']);
        $this->processIndicator = new ProcessIndicator();
    }
}
