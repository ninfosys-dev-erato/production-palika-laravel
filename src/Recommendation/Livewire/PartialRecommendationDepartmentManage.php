<?php

namespace Src\Recommendation\Livewire;

use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\Recommendation\Models\Recommendation;
use Livewire\Attributes\Modelable;

class PartialRecommendationDepartmentManage extends Component
{
    use SessionFlash;

    public ?Recommendation $recommendation;
    public  $departments = [];

    #[Modelable]
    public  $selectedDepartments = [];


    public function mount(Recommendation $recommendation)
    {
        $appLanguage = getAppLanguage();
        $this->recommendation = $recommendation;
        $this->departments = $this->getDepartments($appLanguage);
        $this->selectedDepartments = $this->recommendation->departments?->pluck('id')->toArray() ?? [];
    }

    public function render()
    {
        return view('Recommendation::livewire.recommendation.partial-manage-department');
    }


    public function getDepartments(string $language): array
    {
        $title = $language === "en" ? "title_en" : "title";
        $departments = Branch::pluck('id', $title)?->toArray() ?? [];
        return $departments;
    }
}
