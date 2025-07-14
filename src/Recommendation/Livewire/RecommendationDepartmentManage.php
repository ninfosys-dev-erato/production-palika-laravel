<?php

namespace Src\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\Recommendation\Models\Recommendation;

class RecommendationDepartmentManage extends Component
{
    use SessionFlash;

    public ?Recommendation $recommendation;
    public  array $departments = [];
    public  array $selectedDepartments = [];


    public function mount(Recommendation $recommendation)
    {
        $appLanguage = getAppLanguage();
        $this->recommendation = $recommendation;
        $this->departments = $this->getDepartments($appLanguage);
        $this->selectedDepartments = $this->recommendation->departments?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view('Recommendation::livewire.recommendation.manage-department');
    }

    public function save()
    {
        $this->recommendation->departments()->sync($this->selectedDepartments);
        $this->successFlash(__('recommendation::recommendation.department_assigned_successfully'));

        return redirect()->route('admin.recommendations.recommendation.manage', ['id' => $this->recommendation->id]);
    }

    public function getDepartments(string $language): array
    {
        $title = $language === "en" ? "title_en" : "title";
        $departments = Branch::pluck('id', $title)?->toArray() ?? [];
        return $departments;
    }
}
