<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\ConfigurationAdminDto;
use Src\Yojana\Models\Configuration;
use Src\Yojana\Models\Type;
use Src\Yojana\Service\ConfigurationAdminService;
use Livewire\Attributes\On;

class ConfigurationForm extends Component
{
    use SessionFlash;

    public ?Configuration $configuration;
    public ?Action $action = Action::CREATE;
    public $types;

    public function rules(): array
    {
        return [
            'configuration.title' => ['required'],
            'configuration.amount' => ['required', 'min:0'],
            'configuration.rate' => ['required', 'min:0'],
            'configuration.type_id' => ['required'],
            'configuration.use_in_cost_estimation' => ['nullable'],
            'configuration.use_in_payment' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'configuration.title.required' => __('yojana::yojana.title_is_required'),
            'configuration.amount.required' => __('yojana::yojana.amount_is_required'),
            'configuration.amount.min:0' => __('yojana::yojana.amount_must_be_at_least_min_characters'),
            'configuration.rate.required' => __('yojana::yojana.rate_is_required'),
            'configuration.rate.min:0' => __('yojana::yojana.rate_must_be_at_least_min_characters'),
            'configuration.type_id.required' => __('yojana::yojana.type_id_is_required'),
            'configuration.use_in_cost_estimation.nullable' => __('yojana::yojana.use_in_cost_estimation_is_optional'),
            'configuration.use_in_payment.nullable' => __('yojana::yojana.use_in_payment_is_optional'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.configurations.form");
    }

    public function mount(Configuration $configuration, Action $action)
    {

        $this->types = Type::pluck('title', 'id');
        $this->configuration = $configuration;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = ConfigurationAdminDto::fromLiveWireModel($this->configuration);
        $service = new ConfigurationAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.configuration_created_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.configurations.index');
                break;
            case Action::UPDATE:
                $service->update($this->configuration, $dto);
                $this->successFlash(__('yojana::yojana.configuration_updated_successfully'));
                $this->dispatch('close-modal');
//                return redirect()->route('admin.configurations.index');
                break;
            default:
                return redirect()->route('admin.configurations.index');
                break;
        }
    }

    #[On('edit-configuration')]
    public function editConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->action = Action::UPDATE;
        $this->dispatch('open-modal');
    }
    #[On('reset-form')]
    public function resetConfiguration()
    {
        $this->reset(['configuration', 'action']);
        $this->configuration = new Configuration();
    }
}
