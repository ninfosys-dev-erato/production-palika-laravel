<?php

namespace Src\Recommendation\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\GlobalFacade;
use App\Facades\ImageServiceFacade;
use App\Models\User;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Customers\Models\Customer;
use Src\Recommendation\DTO\ApplyRecommendationAdminDto;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Recommendation\Services\RecommendationAdminService;
use Src\Recommendation\Services\RecommendationService;
use Src\Settings\Models\FiscalYear;
use Src\Settings\Models\Form;

class ApplyRecommendationForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?ApplyRecommendation $applyRecommendation;
    public ?Form $form;
    public ?Recommendation $recommendation;
    public ?Action $action;
    public array $fields = [];
    public array $data = [];
    public $recommendation_id;
    public $recommendation_category_id;
    public $customer_id;
    public $fiscal_year_id;
    public bool $showCustomerKycModal = false;
    public ?bool $isModalForm;
    public ?bool $showCategory = true;
    public ?User $signee;
    public $selectedSignee;
    public $fiscalYears;

    public array $recommendations = [];
    public $customers;

    public function rules(): array
    {
        return [
            'applyRecommendation.customer_id' => ['required', 'integer', 'exists:tbl_customers,id,deleted_at,NULL'],
            'applyRecommendation.fiscal_year_id' => ['required', 'integer', 'exists:mst_fiscal_years,id,deleted_at,NULL'],
            'recommendation_id' => ['required', 'integer', 'exists:rec_recommendation_categories,id,deleted_at,NULL'],
            'applyRecommendation.data' => ['required'],
            'applyRecommendation.remarks' => ['required', 'string']
        ];
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

    public function mount(ApplyRecommendation $applyRecommendation, Action $action, $recommendation = null)
    {
        if ($applyRecommendation->status == RecommendationStatusEnum::ACCEPTED) {
            $this->successFlash(__('recommendation::recommendation.recommendation_has_been_accepted'));
            return redirect()->route('admin.recommendations.apply-recommendation.index');
        }
        $this->action = $action;
        $this->isModalForm = true;
        $this->applyRecommendation = $applyRecommendation->load('customer');
        $this->customer_id = $applyRecommendation->customer_id ?? null;
        $this->recommendation_id = $applyRecommendation->recommendation_id ?? $recommendation->id ?? null;


        $this->data = $applyRecommendation->data ?? [];
        if ($action !== Action::CREATE) {
            $recommendation = $applyRecommendation->recommendation;
        }
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->whereNull('deleted_by')->get();
        if ($recommendation->id) {

            ($this->data === []) ? $this->setFields($recommendation->id) : false;
            $this->recommendation = $recommendation;
            $this->showCategory = false;
            $this->recommendation_category_id = $recommendation->recommendation_category_id;
            $this->recommendation_id = $recommendation->id;
            $this->fiscal_year_id = $this->applyRecommendation->fiscal_year_id;
        }
        $this->customers = $this->getCustomers();
    }

    // public function getCustomers()
    // {
    //     $query = Customer::select('id', 'name', 'mobile_no')
    //         ->whereNull('deleted_at')->whereNotNull('kyc_verified_at');

    //     $user = auth()->user()->fresh();
    //     if (!$user->hasRole('super-admin')) {
    //         $query->where(function ($q) use ($user) {
    //             $q->whereHas('kyc', function ($subQuery) {

    //                 $subQuery->where('permanent_ward', GlobalFacade::ward());
    //             })->orWhere('created_by', $user->id);
    //         });
    //     }
    //     return $query->get();
    // }

    // #[On('customer-selected')]
    // public function updatedCustomer()
    // {
    //     $this->customers = $this->getCustomers();
    // }



    public function getCustomers()
    {
        $user = auth()->user()->fresh();
        $cacheKey = 'customers_' . $user->id . '_' . GlobalFacade::ward();

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($user) {
            $query = Customer::select('id', 'name', 'mobile_no')
                ->whereNull('deleted_at')->whereNotNull('kyc_verified_at');

            $user = auth()->user()->fresh();
            if (!$user->hasRole('super-admin')) {
                $query->where(function ($q) use ($user) {
                    $q->whereHas('kyc', function ($subQuery) {

                        $subQuery->where('permanent_ward', GlobalFacade::ward());
                    })->orWhere('created_by', $user->id);
                });
            }
            return $query
                ->with('kyc')
                ->limit(1000)
                ->get();
        });
    }

    #[On('customer-selected')]
    public function refreshCustomers()
    {
        $user = auth()->user()->fresh();
        $cacheKey = 'customers_' . $user->id . '_' . GlobalFacade::ward();

        Cache::forget($cacheKey);

        $this->customers = $this->getCustomers();
    }


    public function loadRecommendation($categoryId)
    {
        if ($categoryId) {
            $this->recommendations = Recommendation::where('recommendation_category_id', $categoryId)->whereNull('deleted_at')->whereNull('deleted_by')->pluck('title', 'id')->toArray();
        } elseif (!is_numeric($categoryId)) {
            $this->recommendations = [];
            $this->data = [];
            return;
        }
    }

    public function setFields($recommendationId)
    {
        $this->data = [];
        $recommendation = Recommendation::with('form')->find($recommendationId);

        $this->data = collect(json_decode($recommendation->form?->fields, true))
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
                } elseif ($field['type'] === "group") {
                    $fields = [];
                    foreach ($field as $key => $values) {
                        if (is_numeric($key)) {
                            $values['value'] = $this->initializeFieldValue($values);
                            $fields[$values['slug']] = $values;
                            unset($field[$key]);
                        }
                    }
                    $field['fields'] = $fields;
                }

                return $field;
            })
            ->mapWithKeys(function ($field) {
                return [$field['slug'] => $field];
            })
            ->toArray();
    }

    private function initializeFieldValue(array $field): mixed
    {
        return match ($field['type']) {
            'select' => ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null,
            'checkbox' => [],
            'file' => ($field['is_multiple'] ?? 'no') === 'yes' ? [] : null,
            default => null
        };
    }


    #[On('signee-selected')]
    public function setSignee(User $signee)
    {
        $this->selectedSignee = $signee;
    }
    public function addTableRow(string $tableName)
    {
        $tableKey = collect($this->data)
            ->search(fn($item) => isset($item['slug']) && $item['slug'] === $tableName);

        $table = $this->data[$tableKey];
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

    public function openCustomerKycModal()
    {
        $this->showCustomerKycModal = true;
    }

    public function closeCustomerKycModal()
    {
        $this->showCustomerKycModal = false;
    }

    public function render()
    {
        $recommendationCategory = RecommendationCategory::whereNull('deleted_at')->whereNull('deleted_by')->pluck('title', 'id')->toArray();
        return view("Recommendation::livewire.apply-recommendation.form", compact('recommendationCategory'));
    }

    public function save()
    {
        $this->applyRecommendation->data = $this->getFormattedData();
        $this->applyRecommendation->customer_id = $this->customer_id;
        $this->applyRecommendation->fiscal_year_id = $this->fiscal_year_id;
        $this->applyRecommendation->recommendation_id = $this->recommendation_id;
        $this->applyRecommendation->signee_id = $this->selectedSignee ? $this->selectedSignee->id : null;
        $this->applyRecommendation->signee_type = $this->selectedSignee ?  get_class($this->selectedSignee) : null;

        $customer = $this->applyRecommendation->customer;
        $dto = ApplyRecommendationAdminDto::fromLiveWireModel($this->applyRecommendation);
        $service = new RecommendationService();
        if ($this->action === Action::CREATE) {
            $service->create($dto, $customer);
            $this->successFlash(__('recommendation::recommendation.recommendation_applied_successfully'));
        } elseif ($this->action === Action::UPDATE) {
            $service->update($this->applyRecommendation, $dto, $customer);
            $this->successFlash(__('recommendation::recommendation.recommendation_updated_successfully'));
        }

        return redirect()->route('admin.recommendations.apply-recommendation.index');
    }


    private function getFormattedData(): array
    {
        $processedData = [];

        foreach ($this->data as $fieldSlug => $fieldValue) {
            $fieldDefinition = collect($this->data)->firstWhere('slug', $this->data[$fieldValue['slug']]['slug'] ?? $fieldSlug);

            if ($fieldDefinition && $fieldDefinition['type'] === 'table') {
                $tableData = [];

                foreach ($fieldValue['fields'] as $index => $field) {
                    $processedRow = [];

                    foreach ($field as $rowKey => $rowValue) {
                        if (is_array($rowValue) && isset($rowValue['value']) && is_string($rowValue['value'])) {
                            // Convert value inside nested structure
                            $rowValue['value'] = replaceNumbers($rowValue['value'], true);
                            $processedRow[$rowKey] = $rowValue;
                        } else {
                            $processedRow[$rowKey] = $rowValue;
                        }
                    }

                    if (!empty($processedRow)) {
                        $tableData[] = $processedRow;
                    }
                }

                $processedData[$fieldSlug] = [
                    'label' => $fieldDefinition['label'] ?? '',
                    'slug' => $fieldSlug,
                    'type' => 'table',
                    'fields' => $tableData
                ];
            } elseif ($fieldDefinition['type'] === 'file' && is_array($fieldDefinition)) {
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
                    } else {
                        if ($document instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                            $path = FileFacade::saveFile(config('src.Recommendation.recommendation.path'), "", $document, disk: getStorageDisk('private'));
                            $storedDocuments[] = $path;
                        }
                    }
                }

                $processedData[$fieldSlug] = array_merge(
                    $fieldDefinition ?? [],
                    [
                        'label' => $fieldDefinition['label'] ?? '',
                        'value' => $storedDocuments,
                    ]
                );
            } else {
                $value = $fieldValue['value'] ?? null;

                if (is_string($value)) {
                    $value = replaceNumbers($value, true);
                }

                $processedData[$fieldSlug] = array_merge($fieldDefinition ?? [], [
                    'value' => $value,
                    'label' => $fieldDefinition['label'] ?? '',
                ]);
            }
        }

        return $processedData;
    }
}
