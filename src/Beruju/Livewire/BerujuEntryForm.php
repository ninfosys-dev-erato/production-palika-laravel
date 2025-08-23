<?php

namespace Src\Beruju\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Livewire\Component;
use Src\Beruju\DTO\BerujuEntryDto;
use Src\Beruju\Models\BerujuEntry;
use Src\Beruju\Service\BerujuEntryService;
use Src\Beruju\Enums\BerujuAduitTypeEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;
use Src\Beruju\Enums\BerujuCurrencyTypeEnum;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Src\Employees\Models\Branch;
use Src\Beruju\Models\SubCategory;
use Illuminate\Support\Facades\Session;

class BerujuEntryForm extends Component
{
    use SessionFlash;

    public ?BerujuEntry $berujuEntry;
    public ?Action $action;
    public array $subCategories = [];
    public $fiscalYears = [];
    public $branches = [];
    public $auditTypeOptions;
    public $berujuCategoryOptions;
    public $currencyTypeOptions;
    public $isMonetary = false;
    public $childSubCategories = [];
    public $subCategoryLevels = []; // Store multiple levels of subcategories
    public $selectedSubCategoryPath = []; // Store the selected path for editing

    public function rules(): array
    {
        return [
            // Form fields from form.blade.php
            'berujuEntry.name' => ['nullable', 'string'],
            'berujuEntry.fiscal_year_id' => ['nullable', 'string'],
            'berujuEntry.audit_type' => ['nullable', 'string'],
            'berujuEntry.entry_date' => ['nullable', 'string'],
            'berujuEntry.reference_number' => 'nullable|string|max:255',
            'berujuEntry.contract_number' => 'nullable|string|max:255',
            'berujuEntry.branch_id' => 'nullable|exists:mst_branches,id',
            'berujuEntry.project' => ['nullable', 'string'],
            'berujuEntry.beruju_category' => ['nullable', 'string'],
            'berujuEntry.sub_category_id' => ['nullable', 'string'],
            'berujuEntry.amount' => ['nullable', 'string'],
            'berujuEntry.currency_type' => ['nullable', 'string'],
            'berujuEntry.legal_provision' => ['nullable', 'string'],
            'berujuEntry.action_deadline' => ['nullable', 'string'],
            'berujuEntry.description' => ['nullable', 'string'],
            'berujuEntry.beruju_description' => ['nullable', 'string'],
            'berujuEntry.owner_name' => ['nullable', 'string'],
            'berujuEntry.dafa_number' => ['nullable', 'string'],
            'berujuEntry.notes' => ['nullable', 'string'],
            // Additional fields
            'berujuEntry.status' => ['nullable', 'string'],
            'berujuEntry.submission_status' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'berujuEntry.status.required' => __('beruju::beruju.the_status_field_is_required'),
            'berujuEntry.submission_status.required' => __('beruju::beruju.the_submission_status_field_is_required'),
        ];
    }

    public function render()
    {
        return view("Beruju::livewire.form");
    }

    public function mount(BerujuEntry $berujuEntry, Action $action)
    {
        $this->berujuEntry = $berujuEntry;
        $this->action = $action;

        $this->loadEnumOptions();
        $this->fiscalYears = getFiscalYears()->pluck('year', 'id')->toArray();
        $this->branches = Branch::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->subCategories = SubCategory::whereNull('deleted_at')->pluck('name_nep', 'id')->toArray();
        
        // Initialize isMonetary based on current beruju category
        if ($this->berujuEntry->beruju_category === BerujuCategoryEnum::MONETARY_BERUJU) {
            $this->isMonetary = true;
        } else {
            $this->isMonetary = false;
        }
    }

    private function loadEnumOptions()
    {
        // Load audit type options
        $this->auditTypeOptions = BerujuAduitTypeEnum::getForWeb();

        // Load beruju category options
        $this->berujuCategoryOptions = BerujuCategoryEnum::getForWeb();

        // Load currency type optionss
        $this->currencyTypeOptions = BerujuCurrencyTypeEnum::getForWeb();
    }

    public function onBerujuCategoryChange($value)
    {
        if ($value === BerujuCategoryEnum::MONETARY_BERUJU->value) {
            $this->isMonetary = true;
        } else {
            $this->isMonetary = false;
        }
    }

    public function onSubCategoryChange($value, $level = 0)
    {
        if ($value) {
            $subCategory = SubCategory::find($value);
            if ($subCategory) {
                // Find child subcategories
                $childSubCategories = SubCategory::where('parent_id', $subCategory->id)
                    ->orWhere('parent_slug', $subCategory->slug)
                    ->orWhere('parent_name_nep', $subCategory->name_nep)
                    ->orWhere('parent_name_eng', $subCategory->name_eng)
                    ->get()
                    ->pluck('name_nep', 'id')
                    ->toArray();
                
                // Store this level's children
                $this->subCategoryLevels[$level] = $childSubCategories;
                
                // Clear all subsequent levels
                for ($i = $level + 1; $i < 10; $i++) {
                    unset($this->subCategoryLevels[$i]);
                }
                
                // Update the sub_category_id with the current selection
                $this->berujuEntry->sub_category_id = $value;
                
                // Also update the main childSubCategories for backward compatibility
                $this->childSubCategories = $childSubCategories;
            }
        } else {
            // Clear this level and all subsequent levels
            unset($this->subCategoryLevels[$level]);
            for ($i = $level + 1; $i < 10; $i++) {
                unset($this->subCategoryLevels[$i]);
            }
            
            if ($level === 0) {
                $this->childSubCategories = [];
                $this->berujuEntry->sub_category_id = null;
            }
        }
    }

    /**
     * Load the complete subcategory hierarchy for editing
     */
    private function loadSubCategoryHierarchy($finalSubCategoryId)
    {
        $currentSubCategory = SubCategory::find($finalSubCategoryId);
        if (!$currentSubCategory) {
            return;
        }

        $hierarchy = [];
        $selectedPath = [];
        $level = 0;

        // Build the hierarchy from the final subcategory up to the root
        while ($currentSubCategory) {
            // Find parent subcategory
            $parentSubCategory = SubCategory::where('id', $currentSubCategory->parent_id)
                ->orWhere('slug', $currentSubCategory->parent_slug)
                ->orWhere('name_nep', $currentSubCategory->parent_name_nep)
                ->orWhere('name_eng', $currentSubCategory->parent_name_eng)
                ->first();

            if ($parentSubCategory) {
                // Get all siblings of current subcategory
                $siblings = SubCategory::where('parent_id', $parentSubCategory->id)
                    ->orWhere('parent_slug', $parentSubCategory->slug)
                    ->orWhere('parent_name_nep', $parentSubCategory->parent_name_nep)
                    ->orWhere('parent_name_eng', $parentSubCategory->parent_name_eng)
                    ->get()
                    ->pluck('name_nep', 'id')
                    ->toArray();

                $hierarchy[$level] = $siblings;
                $selectedPath[$level] = $currentSubCategory->id;
                $currentSubCategory = $parentSubCategory;
                $level++;
            } else {
                // This is a root level subcategory
                // Get all root level subcategories
                $rootSubCategories = SubCategory::whereNull('parent_id')
                    ->whereNull('parent_slug')
                    ->whereNull('parent_name_nep')
                    ->whereNull('parent_name_eng')
                    ->get()
                    ->pluck('name_nep', 'id')
                    ->toArray();

                $hierarchy[$level] = $rootSubCategories;
                $selectedPath[$level] = $currentSubCategory->id;
                break;
            }
        }

        // Reverse the hierarchy to get the correct order (root to leaf)
        $this->subCategoryLevels = array_reverse($hierarchy, true);
        
        // Store the selected path for reference
        $this->selectedSubCategoryPath = array_reverse($selectedPath, true);
    }

    public function save()
    {
        $this->berujuEntry->status = BerujuStatusEnum::SUBMITTED;
        $this->berujuEntry->submission_status = BerujuSubmissionStatusEnum::SUBMITTED;

        try {
            $this->validate();
            $dto = BerujuEntryDto::fromLiveWireModel($this->berujuEntry);
            $service = new BerujuEntryService();

            DB::beginTransaction();

            switch ($this->action) {
                case Action::CREATE:
                    $berujuEntry = $service->store($dto);
                    DB::commit();
                    $this->dispatch('saveAllDocumentsfunction', $berujuEntry->id);
                    $this->successFlash(__('beruju::beruju.beruju_created_successfully'));
                    return redirect()->route('admin.beruju.registration.index');
                    break;

                case Action::UPDATE:
                    $service->update($this->berujuEntry, $dto);
                    DB::commit();

                    $this->dispatch('saveAllDocumentsfunction', $this->berujuEntry->id);


                    $this->successFlash(__('beruju::beruju.beruju_updated_successfully'));
                    return redirect()->route('admin.beruju.registration.index');
                    break;

                default:
                    DB::rollBack();
                    return $this->redirect(url()->previous());
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('beruju::beruju.something_went_wrong_while_saving') . ': ' . $e->getMessage());
        }
    }

    public function saveDraft()
    {
        $this->berujuEntry->status = BerujuStatusEnum::DRAFT;
        $this->berujuEntry->submission_status = BerujuSubmissionStatusEnum::DRAFT;

        try {
            $dto = BerujuEntryDto::fromLiveWireModel($this->berujuEntry);
            $service = new BerujuEntryService();

            DB::beginTransaction();

            switch ($this->action) {
                case Action::CREATE:
                    $berujuEntry = $service->store($dto);
                    DB::commit();

                    $this->dispatch('saveAllDocumentsfunction', $berujuEntry->id);

                    $this->successFlash(__('beruju::beruju.beruju_draft_saved_successfully'));
                    return redirect()->route('admin.beruju.registration.index');
                    break;

                case Action::UPDATE:
                    $service->update($this->berujuEntry, $dto);
                    DB::commit();

                    $this->dispatch('saveAllDocumentsfunction', $this->berujuEntry->id);

                    $this->successFlash(__('beruju::beruju.beruju_draft_updated_successfully'));
                    return redirect()->route('admin.beruju.registration.index');
                    break;

                default:
                    DB::rollBack();
                    return $this->redirect(url()->previous());
                    break;
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
            $this->errorFlash(__('beruju::beruju.something_went_wrong_while_saving_draft') . ': ' . $e->getMessage());
        }
    }
}
