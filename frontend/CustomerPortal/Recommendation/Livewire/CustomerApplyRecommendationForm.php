<?php

namespace Frontend\CustomerPortal\Recommendation\Livewire;

use App\Enums\Action;
use App\Facades\ActivityLogFacade;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Frontend\CustomerPortal\Recommendation\DTO\ApplyRecommendationAdminDto;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Recommendation\Services\RecommendationService;
use Src\Settings\Models\Form;

class CustomerApplyRecommendationForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?ApplyRecommendation $applyRecommendation;
    public ?Form $form;
    public $recommendation;
    public ?Action $action;
    public  $fields = [];
    public  $data = [];
    public $recommendation_id;
    public $customer_id;
    public bool $admin = false;

    public  $recommendations = []; 
    public $recommendation_category_id;

    public ?bool $showCategory = true;

    public function rules(): array
    {
        return [
            'applyRecommendation.customer_id' => ['required', 'integer', 'exists:tbl_customers,id,deleted_at,NULL'],
            'applyRecommendation.recommendation_id' => ['required', 'integer', 'exists:rec_recommendation_categories,id,deleted_at,NULL'],
            'applyRecommendation.data' => ['required'],
            'applyRecommendation.remarks' => ['required', 'string'],
        ];
    }

    public function mount(ApplyRecommendation $applyRecommendation, Action $action, $recommendation = null)
    {
        $this->recommendation = $recommendation;
        $this->action = $action;
        $this->applyRecommendation = $applyRecommendation->load('customer');
        $this->customer_id = $applyRecommendation->customer_id ?? Auth::guard('customer')->id();
        $this->recommendation_id = $applyRecommendation->recommendation_id ?? null;
        
        $this->data = $applyRecommendation->data ?? [];
        $this->admin = false;

        if($action !== Action::CREATE){
            $recommendation = $applyRecommendation->recommendation;
        }
        if($recommendation->id){
            ($this->data === [])? $this->setFields($recommendation->id):false;
            $this->recommendation = $recommendation;
            $this->showCategory = false;
            $this->recommendation_category_id = $recommendation->recommendation_category_id;
            $this->recommendation_id = $recommendation->id;
        }
    }

    public function loadRecommendation($categoryId)
    {
        if ($categoryId) {
            $this->recommendations = Recommendation::where('recommendation_category_id', $categoryId)->whereNull('deleted_at')->whereNull('deleted_by')->get();
        } elseif(!is_numeric($categoryId)) {
            $this->recommendations = [];
            $this->data = [];
            return;
        }
    }

    public function setFields($recommendationId)
    {
        $this->data = [];
        $recommendation = Recommendation::with('form')->find($recommendationId);

        $this->data = collect(json_decode($recommendation->form->fields, true))
            ->filter(function ($field) {
                return isset($field['type']);
            })
            ->map(function ($field) {
                if ($field['type'] === "table") {
                    $field['fields'] = [];
                    $row = [];
                    foreach ($field as $key => $values) {
                        if (is_numeric($key)) {
                            $row[$values['slug']] = $values;
                            unset($field[$key]);
                        }
                    }
                    $field['fields'][] = $row;
                }
                return $field;
            })
            ->mapWithKeys(function ($field) {
                return [$field['slug'] => $field];
            })
            ->toArray();
    }

    public function addTableRow($tableName)
    {
        $tableKey = collect($this->data)
            ->search(fn($item) => isset($item['slug']) && $item['slug'] === $tableName);
        if ($tableKey === false) {
            throw new \Exception("Table '{$tableName}' not found in the data structure.");
        }

        $table = $this->data[$tableKey];
        if (!isset($table['fields'][0])) {
            throw new \Exception("No field template available for table '{$tableName}'.");
        }
        $newRow = array_map(function ($field) {
            $field['value'] = null; 
            return $field;
        }, $table['fields'][0]);
        $this->data[$tableKey]['fields'][] = $newRow;
    }
    public function removeTableRow($tableName, $index)
    {
        if (isset($this->data[$tableName]['fields'][$index])) {
            unset($this->data[$tableName]['fields'][$index]);
        }
    }

    public function render()
    {
        $recommendationCategory = RecommendationCategory::whereNull('deleted_by')->whereNull('deleted_at')->pluck('title', 'id')->toArray();
       
        return view("CustomerPortal.Recommendation::livewire.customerApplyRecommendation.form",compact('recommendationCategory'));
    }

    public function save()
    {
        $this->applyRecommendation->data = $this->getFormattedData();
        $this->applyRecommendation->customer_id = $this->customer_id;
        $this->applyRecommendation->recommendation_id = $this->recommendation_id;

        $customer = $this->applyRecommendation->customer;
        try{
            $dto = ApplyRecommendationAdminDto::fromLiveWireModel($this->applyRecommendation);
            $service = new RecommendationService();
            ActivityLogFacade::logForCustomer();
            if ($this->action === Action::CREATE) {
                $service->create($dto, $customer); 
                $this->successFlash(__("recommendation::recommendation.recommendation_applied_successfully"));
            } elseif ($this->action === Action::UPDATE) {
                $service->update($this->applyRecommendation, $dto, $customer);
                $this->successFlash(__("recommendation::recommendation.recommendation_updated_successfully"));
            }
        
            return redirect()->route('customer.recommendations.apply-recommendation.index');
        }catch (\Throwable $e){
            logger($e->getMessage());
            $this->errorFlash((('Something went wrong while saving.' . $e->getMessage())));
        }
    }


    private function getFormattedData(): array
    {
        $processedData = [];

        foreach ($this->data as $fieldSlug => $fieldValue) {
            if (!is_array($fieldValue) || !isset($fieldValue['slug'])) {
                // Skip if slug is not set
                continue;
            }

            $fieldSlugKey = $fieldValue['slug'];
            $fieldDefinition = collect($this->data)->firstWhere('slug', $fieldSlugKey);

            if ($fieldDefinition && ($fieldDefinition['type'] ?? null) === 'table') {
                $tableData = [];

                foreach ($fieldValue['fields'] ?? [] as $index => $field) {
                    $processedRow = [];

                    foreach ($field as $rowKey => $rowValue) {
                        $processedRow[$rowKey] = $rowValue;
                    }

                    if (!empty($processedRow)) {
                        $tableData[] = $processedRow;
                    }
                }

                $processedData[$fieldSlug] = [
                    'label' => $fieldDefinition['label'] ?? '',
                    'slug' => $fieldSlug,
                    'type' => 'table',
                    'fields' => $tableData,
                ];
            } elseif (($fieldDefinition['type'] ?? null) === 'file' && is_array($fieldDefinition)) {
                $storedDocuments = [];

                if (isset($fieldDefinition['value'])) {
                    $document = $fieldDefinition['value'];

                    if (is_array($document)) {
                        foreach ($document as $file) {
                            if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                $path = FileFacade::saveFile(config('src.Recommendation.recommendation.path'), "", $file, getStorageDisk('private'));
                                $storedDocuments[] = $path;
                            }
                        }
                    } elseif ($document instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        $path = FileFacade::saveFile(config('src.Recommendation.recommendation.path'), "", $document, disk: getStorageDisk('private'));
                        $storedDocuments[] = $path;
                    }
                }

                $processedData[$fieldSlug] = array_merge($fieldDefinition ?? [], [
                    'label' => $fieldDefinition['label'] ?? '',
                    'value' => $storedDocuments,
                ]);
            } else {
                $processedData[$fieldSlug] = array_merge($fieldDefinition ?? [], [
                    'value' => $fieldValue['value'] ?? null,
                    'label' => $fieldDefinition['label'] ?? '',
                ]);
            }
        }

        return $processedData;
    }

    public function messages(): array
    {
        return [
            'applyRecommendation.customer_id.required' => __('recommendation::recommendation.customer_id_is_required'),
            'applyRecommendation.customer_id.integer' => __('recommendation::recommendation.customer_id_must_be_an_integer'),
            'applyRecommendation.customer_id.exists:tbl_customers' => __('recommendation::recommendation.customer_id_has_invalid_validation_exists'),
            'applyRecommendation.customer_id.id' => __('recommendation::recommendation.customer_id_has_invalid_validation_id'),
            'applyRecommendation.customer_id.deleted_at' => __('recommendation::recommendation.customer_id_has_invalid_validation_deleted_at'),
            'applyRecommendation.customer_id.NULL' => __('recommendation::recommendation.customer_id_has_invalid_validation_null'),
            'applyRecommendation.fiscal_year_id.required' => __('recommendation::recommendation.fiscal_year_id_is_required'),
            'applyRecommendation.fiscal_year_id.integer' => __('recommendation::recommendation.fiscal_year_id_must_be_an_integer'),
            'applyRecommendation.fiscal_year_id.exists:mst_fiscal_years' => __('recommendation::recommendation.fiscal_year_id_has_invalid_validation_exists'),
            'applyRecommendation.fiscal_year_id.id' => __('recommendation::recommendation.fiscal_year_id_has_invalid_validation_id'),
            'applyRecommendation.fiscal_year_id.deleted_at' => __('recommendation::recommendation.fiscal_year_id_has_invalid_validation_deleted_at'),
            'applyRecommendation.fiscal_year_id.NULL' => __('recommendation::recommendation.fiscal_year_id_has_invalid_validation_null'),
            'recommendation_id.required' => __('recommendation::recommendation.recommendation_id_is_required'),
            'recommendation_id.integer' => __('recommendation::recommendation.recommendation_id_must_be_an_integer'),
            'recommendation_id.exists:rec_recommendation_categories' => __('recommendation::recommendation.recommendation_id_has_invalid_validation_exists'),
            'recommendation_id.id' => __('recommendation::recommendation.recommendation_id_has_invalid_validation_id'),
            'recommendation_id.deleted_at' => __('recommendation::recommendation.recommendation_id_has_invalid_validation_deleted_at'),
            'recommendation_id.NULL' => __('recommendation::recommendation.recommendation_id_has_invalid_validation_null'),
            'applyRecommendation.data.required' => __('recommendation::recommendation.data_is_required'),
            'applyRecommendation.remarks.required' => __('recommendation::recommendation.remarks_is_required'),
            'applyRecommendation.remarks.string' => __('recommendation::recommendation.remarks_must_be_a_string'),
        ];
    }   
}