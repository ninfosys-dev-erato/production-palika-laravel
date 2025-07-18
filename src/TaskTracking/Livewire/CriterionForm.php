<?php

namespace Src\TaskTracking\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\TaskTracking\DTO\CriterionAdminDto;
use Src\TaskTracking\Models\Anusuchi;
use Src\TaskTracking\Models\Criterion;
use Src\TaskTracking\Service\CriterionAdminService;

class CriterionForm extends Component
{
    use SessionFlash;

    public ?Anusuchi $anusuchi;
    public ?Action $action;
    public array $criterion = [];

    public function rules(): array
    {
        return [
    'criterion.*.name' => ['required'],
    'criterion.*.name_en' => ['required'],
    'criterion.*.max_score' => ['required'],
    'criterion.*.min_score' => ['required'],
];
    }
    public function messages(): array
    {
        return [
            'criterion.*.name.required' => __('tasktracking::tasktracking.name_is_required'),
            'criterion.*.name_en.required' => __('tasktracking::tasktracking.name_en_is_required'),
            'criterion.*.max_score.required' => __('tasktracking::tasktracking.max_score_is_required'),
            'criterion.*.min_score.required' => __('tasktracking::tasktracking.min_score_is_required'),
        ];
    }

    public function render(){
        return view("TaskTracking::livewire.criteria-form");
    }

    public function mount(Anusuchi $anusuchi,Action $action)
    {
        $this->anusuchi = $anusuchi;
        $this->criterion = $this->anusuchi->criterion?->toArray();
        $this->action = $action;
    }

    public function addCriteria()
    {
        $this->criterion []= [
            'anusuchi_id'=>$this->anusuchi?->id ?? 0,
            'name'=>'',
            'name_en'=>'',
            'max_score'=>0,
            'min_score'=>0,
        ];
    }

}
