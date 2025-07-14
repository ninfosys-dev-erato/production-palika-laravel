<?php

namespace Src\Recommendation\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Recommendation\DTO\RecommendationAdminDto;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Services\RecommendationAdminService;

class RecommendationForm extends Component
{
    use SessionFlash;

    public ?Recommendation $recommendation;
    public array $initialRecommendation = [];
    public ?Action $action;
    public array $documents = [];
    public array $selectedRoles = [];
    public array $selectedDepartments = [];
    public int $step = 1;
    public int $maxPages = 4;
    public bool $is_ward_recommendation = false;

    public function rules(): array
    {
        return [
            'initialRecommendation.title' => ['required', 'string'],
            'initialRecommendation.recommendation_category_id' => ['required', 'integer', 'exists:rec_recommendation_categories,id,deleted_at,NULL'],
            'initialRecommendation.form_id' => ['required', 'integer', 'exists:mst_forms,id,deleted_at,NULL'],
            'initialRecommendation.revenue' => ['required', 'numeric'],
            'is_ward_recommendation' => ['nullable', 'boolean'],
            'documents' => ['array'],
            'documents.*.title' => ['required', 'string'],
            'documents.*.is_required' => ['nullable', 'boolean'],
            'documents.*.accept' => ['nullable', 'string'],
        ];
    }

    public function render()
    {
        return view("Recommendation::livewire.recommendation.form");
    }

    public function mount(Recommendation $recommendation, Action $action)
    {
        $this->recommendation = $recommendation;
        $this->initialRecommendation = $recommendation?->toArray();
        $this->action = $action;
        $this->documents = $recommendation->recommendationDocuments?->toArray();
        $this->selectedRoles = $this->recommendation->roles?->pluck('id')->toArray() ?? [];
        $this->selectedDepartments = $this->recommendation->departments?->pluck('id')->toArray() ?? [];
        if($this->initialRecommendation )
        {
             $this->is_ward_recommendation = $this->initialRecommendation['is_ward_recommendation'];
    }
}
    public function nextPage(): void
    {
        $this->validate(); 
        if ($this->step < $this->maxPages) {
            $this->step++;
        }
    }
    
    public function previousPage(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function addDocument()
    {
        $this->documents[] = [
            'title' => '',
            'is_required' => false,
            'accept' => '',
        ];
    }

    public function removeDocument($index)
    {
        unset($this->documents[$index]);
        $this->documents = array_values($this->documents);
    }

    public function redirectToIndex()
    {
        $this->successFlash(__('recommendation::recommendation.recommendation_updated_successfully'));
            return redirect()->route('admin.recommendations.recommendation.index');
    }

    public function save()
    {
        $this->validate();
        $this->initialRecommendation['is_ward_recommendation'] = $this->is_ward_recommendation;
        $this->initialRecommendation['recommendationDocuments'] = $this->documents;
        try{
            $dto = RecommendationAdminDto::fromLiveWireArray($this->initialRecommendation);
            
            $service = new RecommendationAdminService();
            
            switch ($this->action) {
                case Action::CREATE:
                     $createdRecommendation = $service->store($dto, $this->selectedRoles, $this->selectedDepartments);
                     $this->recommendation = $createdRecommendation;
                     $this->step = 4;
                    break;
                
                case Action::UPDATE:
                    $service->update($this->recommendation, $dto, $this->selectedRoles,  $this->selectedDepartments);
                    $this->step = 4;
                    break;
                
                default:
                    return redirect()->route('admin.recommendations.recommendation.index');
            }
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }

    public function messages()
    {
        return [
            'initialRecommendation.title.required' => __('recommendation::recommendation.the_title_is_required'),
            'initialRecommendation.recommendation_category_id.required' => __('recommendation::recommendation.the_recommendation_category_is_required'),
            'initialRecommendation.recommendation_category_id.integer' => __('recommendation::recommendation.the_recommendation_category_must_be_a_valid_integer'),
            'initialRecommendation.recommendation_category_id.exists' => __('recommendation::recommendation.the_selected_recommendation_category_is_invalid_or_has_been_deleted'),
            'initialRecommendation.form_id.required' => __('recommendation::recommendation.the_form_is_required'),
            'initialRecommendation.form_id.integer' => __('recommendation::recommendation.the_form_must_be_a_valid_integer'),
            'initialRecommendation.form_id.exists' => __('recommendation::recommendation.the_selected_form_is_invalid_or_has_been_deleted'),
            'initialRecommendation.revenue.required' => __('recommendation::recommendation.the_revenue_field_is_required'),
            'initialRecommendation.revenue.numeric' => __('recommendation::recommendation.the_revenue_must_be_a_valid_number'),
            'is_ward_recommendation.boolean' => __('recommendation::recommendation.the_ward_recommendation_field_must_be_true_or_false'),
            'documents.array' => __('recommendation::recommendation.the_documents_field_must_be_an_array'),
            'documents.*.title.required' => __('recommendation::recommendation.each_document_must_have_a_title'),
            'documents.*.is_required.boolean' => __('The "is required" field for each document must be true or false.'),
            'documents.*.accept.string' => __('recommendation::recommendation.the_accept_field_for_each_document_must_be_a_valid_string'),
        ];
    }
    

}
