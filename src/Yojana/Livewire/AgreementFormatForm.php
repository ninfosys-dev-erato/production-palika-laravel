<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\AgreementFormatAdminDto;
use Src\Yojana\Models\AgreementFormat;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Service\AgreementFormatAdminService;

class AgreementFormatForm extends Component
{
    use SessionFlash;

    public ?AgreementFormat $agreementFormat;
    public ?Action $action;
    public $groupedBindings = [];
    public $implementationMethod;

    public function rules(): array
    {
        return [
            'agreementFormat.implementation_method_id' => ['required'],
            'agreementFormat.name' => ['required'],
            'agreementFormat.sample_letter' => ['nullable'],
            'agreementFormat.styles' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'agreementFormat.implementation_method_id.required' => __('yojana::yojana.implementation_method_id_is_required'),
            'agreementFormat.name.required' => __('yojana::yojana.name_is_required'),
            'agreementFormat.sample_letter.nullable' => __('yojana::yojana.sample_letter_is_optional'),
            'agreementFormat.styles.nullable' => __('yojana::yojana.styles_is_optional'),
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.agreement-formats.form");
    }

    public function mount(AgreementFormat $agreementFormat, Action $action)
    {
        $this->groupedBindings = $this->groupBindingsByModel(config('src.Yojana.template'));
        $this->agreementFormat = $agreementFormat;
        $this->action = $action;
        $this->implementationMethod = ImplementationMethod::whereNull('deleted_at')->pluck('title', 'id');
    }

    public function save()
    {
        $this->validate();
        $dto = AgreementFormatAdminDto::fromLiveWireModel($this->agreementFormat);
        $service = new AgreementFormatAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.agreement_format_created_successfully'));
                return redirect()->route('admin.agreement_formats.index');
                break;
            case Action::UPDATE:
                $service->update($this->agreementFormat, $dto);
                $this->successFlash(__('yojana::yojana.agreement_format_updated_successfully'));
                return redirect()->route('admin.agreement_formats.index');
                break;
            default:
                return redirect()->route('admin.agreement_formats.index');
                break;
        }
    }
    function groupBindingsByModel($variables)
    {
        $grouped = [
            'no_dot' => [],
        ];

        foreach ($variables as $variable) {
            // Check if the variable contains a dot
            if (strpos($variable, '.') === false) {
                // No dot, group under 'no_dot'
                $grouped['no_dot'][] = $variable;
            } else {
                // Extract the first part before the dot
                $parts = explode('.', $variable);
                $model = $parts[0];  // The part before the first dot

                // Group by the model (the first part)
                if (!isset($grouped[$model])) {
                    $grouped[$model] = [];
                }

                // Add the full variable to the corresponding group
                $grouped[$model][] = $variable;
            }
        }

        return $grouped;
    }

}
