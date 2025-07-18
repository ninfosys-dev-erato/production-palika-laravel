<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\LetterSampleAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\LetterType;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\LetterSampleAdminService;
use Src\Yojana\Traits\YojanaTemplate;

class LetterSampleForm extends Component
{
    use SessionFlash, YojanaTemplate;

    public ?LetterSample $letterSample;
    public ?Action $action;
    public $implementationMethods = [];
    public $groupedBindings = [];
    public $letterTypes;
    public $types;

    public function rules(): array
    {
        return [
            'letterSample.letter_type' => ['required'],
            'letterSample.implementation_method_id' => ['required'],
            'letterSample.name' => ['required'],
            'letterSample.subject' => ['required'],
            'letterSample.sample_letter' => ['required'],
            'letterSample.styles' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'letterSample.letter_type.required' => __('yojana::yojana.letter_type_is_required'),
            'letterSample.implementation_method_id.required' => __('yojana::yojana.implementation_method_id_is_required'),
            'letterSample.name.required' => __('yojana::yojana.name_is_required'),
            'letterSample.subject.required' => __('yojana::yojana.subject_is_required'),
            'letterSample.sample_letter.required' => __('yojana::yojana.sample_letter_is_required'),
            'letterSample.styles.nullable' => __('yojana::yojana.styles_is_optional'),

        ];
    }

    public function render()
    {
        return view("Yojana::livewire.letter-samples.form");
    }

    public function mount(LetterSample $letterSample, Action $action)
    {
        $this->groupedBindings = $this->groupBindingsByModel(config('src.Yojana.template'));
        $this->letterSample = $letterSample;
        $this->action = $action;
        $this->implementationMethods = ImplementationMethod::whereNull('deleted_at')->pluck('title', 'id');
//        $this->letterTypes = LetterType::whereNull('deleted_at')->pluck('title', 'id');
        $this->letterTypes = LetterTypes::getValuesWithLabels();
    }

    public function save()
    {
        $this->validate();
        $dto = LetterSampleAdminDto::fromLiveWireModel($this->letterSample);
        $service = new LetterSampleAdminService();
        switch ($this->action) {
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash(__('yojana::yojana.letter_sample_created_successfully'));
                return redirect()->route('admin.letter_samples.index');
                break;
            case Action::UPDATE:
                $service->update($this->letterSample, $dto);
                $this->successFlash(__('yojana::yojana.letter_sample_updated_successfully'));
                return redirect()->route('admin.letter_samples.index');
                break;
            default:
                return redirect()->route('admin.letter_samples.index');
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
