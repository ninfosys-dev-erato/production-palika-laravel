<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Yojana\DTO\PlanTemplateAdminDto;
use Src\Yojana\Models\PlanTemplate;
use Src\Yojana\Service\PlanTemplateAdminService;

class PlanTemplateForm extends Component
{
    use SessionFlash;

    public ?PlanTemplate $planTemplate;
    public ?Action $action;

    public function rules(): array
    {
        return [
    'planTemplate.type' => ['required'],
    'planTemplate.template_for' => ['required'],
    'planTemplate.title' => ['required'],
    'planTemplate.data' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'planTemplate.type.required' => __('yojana::yojana.type_is_required'),
            'planTemplate.template_for.required' => __('yojana::yojana.template_for_is_required'),
            'planTemplate.title.required' => __('yojana::yojana.title_is_required'),
            'planTemplate.data.required' => __('yojana::yojana.data_is_required'),
        ];
    }

    public function render(){
        return view("PlanTemplates::projects.form");
    }

    public function mount(PlanTemplate $planTemplate,Action $action)
    {
        $this->planTemplate = $planTemplate;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        $dto = PlanTemplateAdminDto::fromLiveWireModel($this->planTemplate);
        $service = new PlanTemplateAdminService();
        switch ($this->action){
            case Action::CREATE:
                $service->store($dto);
                $this->successFlash("Plan Template Created Successfully");
                return redirect()->route('admin.plan_templates.index');
                break;
            case Action::UPDATE:
                $service->update($this->planTemplate,$dto);
                $this->successFlash("Plan Template Updated Successfully");
                return redirect()->route('admin.plan_templates.index');
                break;
            default:
                return redirect()->route('admin.plan_templates.index');
                break;
        }
    }
}
