<?php

namespace Src\Recommendation\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Recommendation\DTO\RecommendationCategoryAdminDto;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Recommendation\Services\RecommendationCategoryAdminService;

class RecommendationCategoryForm extends Component
{
    use SessionFlash;

    public ?RecommendationCategory $recommendationCategory;
    public ?Action $action;

    public function rules(): array
    {
        return [
            'recommendationCategory.title' => ['required', 'string'],

        ];
    }

    public function render(){
        return view("Recommendation::livewire.recommendationCategory.form");
    }

    public function mount(RecommendationCategory $recommendationCategory,Action $action)
    {
        $this->recommendationCategory = $recommendationCategory;
        $this->action = $action;
    }

    public function save()
    {
        $this->validate();
        try{
            $dto = RecommendationCategoryAdminDto::fromLiveWireModel($this->recommendationCategory);
            $service = new RecommendationCategoryAdminService();
            switch ($this->action){
                case Action::CREATE:
                    $service->store($dto);
                    $this->successFlash(__('recommendation::recommendation.recommendation_category_created_successfully'));
                    return redirect()->route('admin.recommendations.recommendation-category.index');

                case Action::UPDATE:
                    $service->update($this->recommendationCategory,$dto);
                    $this->successFlash(__('recommendation::recommendation.recommendation_category_updated_successfully'));
                    return redirect()->route('admin.recommendations.recommendation-category.index');
                
                default:
                    return redirect()->route('admin.recommendations.recommendation-category.index');
                
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }
    public function messages(): array
    {
        return [
            'recommendationCategory.title' => __('recommendation::recommendation.the_title_is_required'),
        ];
    }
}
