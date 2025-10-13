<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;
use Src\Yojana\DTO\PlanAdminDto;
use Src\Yojana\Enums\Natures;
use Src\Yojana\Enums\PlanTypes;
use Src\Yojana\Models\BudgetDetail;
use Src\Yojana\Models\BudgetHead;
use Src\Yojana\Models\BudgetSource;
use Src\Yojana\Models\ExpenseHead;
use Src\Yojana\Models\ImplementationLevel;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\PlanArea;
use Src\Yojana\Models\ProjectGroup;
use Src\Yojana\Models\SourceType;
use Src\Yojana\Models\SubRegion;
use Src\Yojana\Models\Target;
use Src\Yojana\Service\PlanAdminService;

class PlanForm extends Component
{
    use SessionFlash;

    public ?Plan $plan;
    public ?Action $action;
    public $implementationMethods;
    public $planAreas;
    public $subRegions;
    public $filteredSubRegions;

    public $targets;
    public $implementationLevels;
    public $projectGroups;
    public $sourceTypes;

    public $programs;

    public $category;
    public $budgetHeads;
    public $expenseHeads;
    public $wards;
    public $fiscalYears;

    public $planTypes;
    public array $natures;
    public $budgetSources = [];
    public $sources;
    public $is_budget_source = true;
    public $departments;
    /**
     * @var true
     */
    public bool $isDepartment = false;

    public function rules(): array
    {
        return [
            'plan.project_name' => ['required'],
            'plan.implementation_method_id' => ['nullable'],
            'plan.location' => ['nullable'],
            'plan.ward_id' => ['nullable'],
            'plan.start_fiscal_year_id' => ['nullable'],
            'plan.operate_fiscal_year_id' => ['nullable'],
            'plan.area_id' => ['nullable'],
            'plan.sub_region_id' => ['nullable'],
            'plan.targeted_id' => ['nullable'],
            'plan.implementation_level_id' => ['nullable'],
            'plan.plan_type' => ['nullable'],
            'plan.nature' => ['nullable'],
            'plan.project_group_id' => ['nullable'],
            'plan.purpose' => ['nullable'],
            'plan.red_book_detail' => ['nullable'],
            'plan.allocated_budget' => ['required','numeric','min:1'],
            'plan.category' => ['required'],
            'plan.department' => ['nullable'],
            //    'plan.source_id' => ['required'],
            //    'plan.program' => ['required'],
            //    'plan.budget_head_id' => ['required'],
            //    'plan.expense_head_id' => ['required'],
            //    'plan.fiscal_year_id' => ['required'],
            //    'plan.amount' => ['required'],

            'budgetSources.*.source_id' => ['required'],
            'budgetSources.*.program' => ['required'],
            'budgetSources.*.budget_head_id' => ['required'],
            'budgetSources.*.expense_head_id' => ['required'],
            'budgetSources.*.fiscal_year_id' => ['required'],
            'budgetSources.*.amount' => ['required', 'numeric', 'min:1']
        ];
    }
    public function messages(): array
    {
        return [
            'plan.project_name.required' => __('yojana::yojana.project_name_is_required'),
            'plan.implementation_method_id.required' => __('yojana::yojana.implementation_method_id_is_required'),
            'plan.location.required' => __('yojana::yojana.location_is_required'),
            'plan.ward_id.required' => __('yojana::yojana.ward_id_is_required'),
            'plan.start_fiscal_year_id.required' => __('yojana::yojana.start_fiscal_year_id_is_required'),
            'plan.operate_fiscal_year_id.required' => __('yojana::yojana.operate_fiscal_year_id_is_required'),
            'plan.area_id.required' => __('yojana::yojana.area_id_is_required'),
            'plan.sub_region_id.required' => __('yojana::yojana.sub_region_id_is_required'),
            'plan.targeted_id.required' => __('yojana::yojana.targeted_id_is_required'),
            'plan.implementation_level_id.required' => __('yojana::yojana.implementation_level_id_is_required'),
            'plan.plan_type.required' => __('yojana::yojana.plan_type_is_required'),
            'plan.nature.required' => __('yojana::yojana.nature_is_required'),
            'plan.project_group_id.required' => __('yojana::yojana.project_group_id_is_required'),
            'plan.purpose.required' => __('yojana::yojana.purpose_is_required'),
            'plan.red_book_detail.required' => __('yojana::yojana.red_book_detail_is_required'),
            'plan.allocated_budget.required' => __('yojana::yojana.allocated_budget_is_required'),
            'budgetSources.*.source_id.required' => __('yojana::yojana.source_id_is_required'),
            'budgetSources.*.program.required' => __('yojana::yojana.program_is_required'),
            'budgetSources.*.budget_head_id.required' => __('yojana::yojana.budget_head_id_is_required'),
            'budgetSources.*.expense_head_id.required' => __('yojana::yojana.expense_head_id_is_required'),
            'budgetSources.*.fiscal_year_id.required' => __('yojana::yojana.fiscal_year_id_is_required'),
            'budgetSources.*.amount.required' => __('yojana::yojana.amount_is_required'),
            'budgetSources.*.amount.numeric' => __('yojana::yojana.amount_must_be_a_number'),
            'budgetSources.*.amount.min:1' => __('yojana::yojana.amount_must_be_at_least_min_characters'),
        ];
    }

    public function render(): View
    {
        return view("Yojana::livewire.plans.form");
    }

    public function mount(Plan $plan, Action $action, $category): void
    {
        $this->plan = $plan;
        $this->action = $action;
        $this->implementationMethods = ImplementationMethod::whereNull('deleted_at')->pluck('title', 'id');
        $this->planAreas = PlanArea::whereNull('deleted_at')->pluck('area_name', 'id');
        $this->subRegions = SubRegion::whereNull('deleted_at')->get();
        $this->filteredSubRegions = $this->subRegions;
        $this->targets = Target::whereNull('deleted_at')->pluck('title', 'id');
        $this->implementationLevels = ImplementationLevel::whereNull('deleted_at')->pluck('title', 'id');
        $this->projectGroups = ProjectGroup::whereNull('deleted_at')->pluck('title', 'id');
        $this->sources = BudgetSource::whereNull('deleted_at')->pluck('title','id');
        $this->programs = BudgetDetail::whereNull('deleted_at')->get() ;
        $this->budgetHeads = BudgetHead::whereNull('deleted_at')->pluck('title', 'id');
        $this->expenseHeads = ExpenseHead::whereNull('deleted_at')->get();
        $this->wards = Ward::whereNull('deleted_at')->pluck('ward_name_ne', 'id');
        $this->fiscalYears = FiscalYear::whereNull('deleted_at')->pluck('year', 'id');
        $this->departments = Branch::whereNull('deleted_at')->pluck('title', 'id');

        $this->plan->category = $category;

        $this->planTypes = PlanTypes::getForWeb();
        $this->natures = Natures::getForWeb();

        $this->budgetSources = $this->plan->budgetSources()->get()->toArray();
    }

    public function loadDepartments()
    {
        $implementationLevel = $this->plan->implementationLevel()->first();
        if ($implementationLevel->code == "department"){ // 8 is the id of department, this can be changed!!!
            $this->isDepartment = true;
        }
        else{
            $this->isDepartment = false;
        }
    }


    public function addBudgetSource(): void
    {
        $this->budgetSources[] = [
            "source_id" => '',
            "program" => '',
            "budget_head_id" => '',
            "expense_head_id" => '',
            "fiscal_year_id" => '',
            "amount" => '',
        ];
        $this->successToast(__('yojana::yojana.yojanamessagessuccess_budget_sources_add'));
    }

    public function removeBudgetSource(int $index): void
    {
        unset($this->budgetSources[$index]);
        $this->budgetSources = array_values($this->budgetSources);

        if ($index == 0) {
            $this->is_budget_source = !$this->is_budget_source;
        }

        $this->recalculateAllocatedBudget();
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->budgetSources = array_filter($this->budgetSources, function ($source) {
                return !empty($source['source_id']) &&
                    !empty($source['program']) &&
                    !empty($source['budget_head_id']) &&
                    !empty($source['expense_head_id']) &&
                    !empty($source['fiscal_year_id']) &&
                    !empty($source['amount']);
            });
            $dto = PlanAdminDto::fromLiveWireModel($this->plan);
            $service = new PlanAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $plan = $service->store($dto);
                    if ($plan) {
                        if (!empty($this->budgetSources)) {
                            $this->createBudgetSource($plan);
                        }
                        DB::commit();
                        $this->successFlash(__('yojana::yojana.plan_created_successfully'));
                        if ($this->plan->category === 'plan') {
                            return redirect()->route('admin.plans.show', ['id' => $plan->id]);
                        } elseif ($this->plan->category === 'program') {
                            return redirect()->route('admin.programs.show', ['id' => $plan->id]);
                        }
                    } else {
                        $this->errorFlash(__('yojana::yojana.failed_to_create_plan'));
                    }
                    break;
                case Action::UPDATE:
                    $service->update($this->plan, $dto);
                    foreach ($this->plan->budgetSources as $existingBudgetSource) {
                        $existingBudgetSource->delete();
                    }
                    $this->createBudgetSource($this->plan);
                    $this->budgetSources = $this->plan->budgetSources->toArray();
                    DB::commit();

                    $this->successFlash(__('yojana::yojana.plan_updated_successfully'));
//                    return redirect()->route('admin.plans.show', ['id' => $this->plan->id]);
                    if ($this->plan->category === 'plan') {
                        return redirect()->route('admin.plans.show', ['id' => $this->plan->id]);
                    } elseif ($this->plan->category === 'program') {
                        return redirect()->route('admin.programs.show', ['id' => $this->plan->id]);
                    }
                    break;
            }
            //        return redirect()->route('admin.plans.index');
            //        dd($plan->id);

        } catch (ValidationException $e) {
            DB::rollBack();
            //            dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            DB::rollBack();
            //            dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }


    public function createBudgetSource($plan): void
    {
        if (!empty($this->budgetSources)) {
            $sources = array_map(function ($source) {
                return [
                    'source_id' => $source['source_id'],
                    'program' => $source['program'],
                    'budget_head_id' => $source['budget_head_id'],
                    'expense_head_id' => $source['expense_head_id'],
                    'fiscal_year_id' => $source['fiscal_year_id'],
                    'amount' => $source['amount'],
                    'remaining_amount' => $source['amount'],
                ];
            }, $this->budgetSources);
            $plan->budgetSources()->createMany($sources);
        }
    }

    public function updateSubRegions($id): void
    {
        $this->filteredSubRegions = $this->subRegions->where('area_id', $id);
    }

    public function recalculateAllocatedBudget(): void
    {
        $amounts = array_map('floatval', array_column($this->budgetSources, 'amount'));
        $this->plan['allocated_budget'] = array_sum($amounts);
        $this->plan['remaining_budget'] = $this->plan['allocated_budget'];
    }

}
