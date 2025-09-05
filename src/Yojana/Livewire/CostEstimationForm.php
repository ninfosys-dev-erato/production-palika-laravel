<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Facades\GlobalFacade;
use App\Facades\PdfFacade;
use App\Traits\HelperDate;
use App\Traits\SessionFlash;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Src\Wards\Models\Ward;
use Src\Yojana\DTO\CostDetailsAdminDto;
use Src\Yojana\DTO\CostEstimationAdminDto;
use Src\Yojana\DTO\CostEstimationConfigurationAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\Activity;
use Src\Yojana\Models\BudgetSource;
use Src\Yojana\Models\Configuration;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\CostEstimationDetail;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\ProjectActivityGroup;
use Src\Yojana\Models\SourceType;
use Src\Yojana\Models\Unit;
use Src\Yojana\Service\AdvancePaymentAdminService;
use Src\Yojana\Service\CostDetailsAdminService;
use Src\Yojana\Service\CostEstimationAdminService;
use Src\Yojana\Service\CostEstimationConfigurationAdminService;
use Src\Yojana\Service\CostEstimationDetailAdminService;
use Src\Settings\Traits\AdminSettings;
use Src\Yojana\Service\WorkOrderAdminService;

class CostEstimationForm extends Component
{
    use SessionFlash, WithFileUploads, HelperDate;

    public ?Plan $plan;
    public ?CostEstimation $costEstimation;
    public  ?CostEstimationDetail $costEstimationDetail;
    public ?Action $action;
    public $activityGroups;
    public $activities;
    public $units;
    public bool $showApprovalLetter = false;

    public bool $is_vatable = false;
    public bool $is_revised = false;

    public $revision_no = 0;
    public $revision_date;

    public $records = [];
    public $configRecords = [];
    public $costRecords = [];
    public $cost_source;
    public $cost_amount;
    public $image;
    public $configurations;
    public $sourceTypes;

    public $totalWithConfig = 0;
    public $totalEstimatedAmount = 0;

    public $total_amount;
    public $total_vat_amount;
    public $totalWithVat;
    public $total_cost;
    public $editingIndex = null;

    public string $rate_analysis_document_url;
    public string $cost_estimation_document_url;
    public string $initial_photo_url;

    protected $listeners = ['configRecordAdded'];

    public $rate_analysis_document;


    public $cost_estimation_document;

    public $initial_photo;

    public $rate_analysis_saved;


    public $cost_estimation_saved;

    public $initial_photo_saved;

    public function rules(): array
    {
        return [
            'costEstimationDetail.id' => 'nullable',
            'costEstimationDetail.activity_group_id' => 'required',
            'costEstimationDetail.activity_id' => 'required',
            'costEstimationDetail.unit' => 'required',
            'costEstimationDetail.quantity' => ['required', 'numeric', 'min:1'],
            'costEstimationDetail.rate' => ['required', 'numeric', 'min:1'],
            'costEstimationDetail.amount' => 'required',
            'costEstimationDetail.vat_amount' => 'nullable',
            'costEstimation.is_revised' => 'nullable',
            'costEstimation.revision_no' => 'nullable',
            'costEstimation.revision_date' => 'nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'costEstimationDetail.quantity.required' => __('yojana::yojana.quantity_is_required'),
            'costEstimationDetail.quantity.numeric' => __('yojana::yojana.quantity_must_be_a_number'),
            'costEstimationDetail.quantity.min:1' => __('yojana::yojana.quantity_must_be_at_least_min_characters'),
            'costEstimationDetail.rate.required' => __('yojana::yojana.rate_is_required'),
            'costEstimationDetail.rate.numeric' => __('yojana::yojana.rate_must_be_a_number'),
            'costEstimationDetail.rate.min:1' => __('yojana::yojana.rate_must_be_at_least_min_characters'),
        ];
    }

    public function render(): View
    {
        return view("Yojana::livewire.cost-estimation.form");
    }

    public function mount(CostEstimation $costEstimation, Plan $plan, CostEstimationDetail $costEstimationDetail, Action $action): void
    {
        $this->costEstimationDetail = $costEstimationDetail;
        $this->action = $action;
        $this->plan = $plan;

        if ($this->plan?->costEstimation?->status === "Approved" && $this->plan?->targetEntries()->exists()) {
            $this->showApprovalLetter = true;
        }

        $this->total_amount = 0;
        $this->total_vat_amount = 0;
        $this->totalWithVat = 0;

        if (isset($plan->costEstimation) || $this->action == Action::UPDATE) {
            if ($plan->costEstimation) {
                $this->loadData();
            }
        } else {
            if ($plan->costEstimation) {
                $this->loadData();
            } else {
                $this->costEstimation =  new CostEstimation();
            }
        }
        $this->activityGroups = ProjectActivityGroup::WhereNull('deleted_at')->pluck('title', 'id');
        $this->activities = Activity::WhereNull('deleted_at')->get();
        $this->configurations = Configuration::whereNull('deleted_at')->pluck('title','id');
        $this->sourceTypes = SourceType::WhereNull('deleted_at')->pluck('title','id');
        $this->units = Unit::WhereNull('deleted_at')->pluck('symbol','id');
        $this->resetForm();
    }


    public function addDetails()
    {
        $this->validate();

        // Check if we're editing a record
        if ($this->editingIndex !== null) {

            // Update the existing record
            $this->records[$this->editingIndex] = [
                'id' => $this->costEstimationDetail->id,
                "activity_group_id" => $this->costEstimationDetail->activity_group_id,
                "activity_id" => $this->costEstimationDetail->activity_id,
                "unit"        => $this->costEstimationDetail->unit,
                "quantity"    => $this->costEstimationDetail->quantity,
                "rate"        => $this->costEstimationDetail->rate,
                "amount"      => $this->costEstimationDetail->amount,
                "vat_amount"  => $this->costEstimationDetail->vat_amount,
            ];

            $this->editingIndex = null;  // Reset editing mode
        } else {
            // Add a new record
            $this->records[] = [
                "activity_group_id" => $this->costEstimationDetail->activity_group_id,
                "activity_id" => $this->costEstimationDetail->activity_id,
                "unit"        => $this->costEstimationDetail->unit,
                "quantity"    => $this->costEstimationDetail->quantity,
                "rate"        => $this->costEstimationDetail->rate,
                "amount"      => $this->costEstimationDetail->amount,
                "vat_amount"  => $this->costEstimationDetail->vat_amount,
            ];
        }

        $this->resetForm();  // Reset the form after add/update
        $this->recalculateTotalAmount();
        $this->calculateConfigAmount();
        $this->recalculateTotalCost();


        $this->dispatch('updateTotals', [
            'total_amount'      => $this->total_amount,
            'total_vat_amount'  => $this->total_vat_amount,
            'totalWithVat'      => $this->totalWithVat,
            'totalWithConfig'   => $this->totalWithConfig,
        ]);
    }

    public function loadUnit($id)
    {
        $activity = $this->activities->firstWhere('id',$id);
        if ($activity->exists()) {
            $this->costEstimationDetail->unit = $activity->unit_id;
        }

    }

    public function removeDetails($index)
    {
        unset($this->records[$index]);
        $this->records = array_values($this->records);
        $this->calculateConfigAmount();
    }

    public function configRecordAdded($data)
    {
        $this->configRecords[] = $data;
        $this->calculateConfigAmount();
        $this->dispatch('close-modal');
    }

    public function removeConfigRecord($index)
    {
        unset($this->configRecords[$index]);
        $this->configRecords = array_values($this->configRecords);
        $this->calculateConfigAmount();
    }

    public function addCostRecord()
    {
        $this->validate([
            'cost_source' => 'required',
            'cost_amount' => 'required|numeric|min:1',
        ]);

        $this->recalculateTotalCost();

        if ($this->totalEstimatedAmount >= $this->total_cost) {
            $this->costRecords[] = [
                'cost_source' => $this->cost_source,
                'cost_amount' => $this->cost_amount,
            ];

            $this->cost_source = null;
            $this->cost_amount = null;
        } else {
            $this->errorFlash(__('yojana::yojana.total_cost_cannot_exceed_estimated'), _(''));
        }
    }

    public function removeCostRecord($index)
    {
        unset($this->costRecords[$index]);
        $this->costRecords = array_values($this->costRecords);
    }

    public function recalculateTotalCost()
    {
        $this->total_cost = array_sum(array_column($this->costRecords, 'cost_amount')) + $this->cost_amount;
    }

    public function calculateConfigAmount()
    {
        $sum = $this->totalWithVat;
        if (isset($this->configRecords)) {
            foreach ($this->configRecords as $record) {
                if ($record['operation_type'] == 'add') {
                    $sum += $record['amount'];
                } elseif ($record['operation_type'] == 'deduct') {
                    $sum -= $record['amount'];
                }
            }
        }
        $this->totalWithConfig = $sum;
        $this->totalEstimatedAmount = $sum;
    }

    public function recalculateTotalAmount()
    {
        $this->total_amount = array_sum(array_column($this->records, 'amount'));
        $this->total_vat_amount = array_sum(array_column($this->records, 'vat_amount'));
        $this->totalWithVat = $this->total_amount + $this->total_vat_amount;
    }
    public function resetForm()
    {
        $this->costEstimationDetail->activity_id = null;
        $this->costEstimationDetail->unit = null;
        $this->costEstimationDetail->quantity = null;
        $this->costEstimationDetail->rate = null;
        $this->costEstimationDetail->amount = null;
        $this->costEstimationDetail->vat_amount = null;
        $this->is_vatable = false;
    }

    public function editDetails($index)
    {
        $record = $this->records[$index];
        $this->costEstimationDetail->id = $record['id'];
        $this->costEstimationDetail->activity_group_id =  $record['activity_group_id'];
        $this->costEstimationDetail->activity_id =  $record['activity_id'];
        $this->costEstimationDetail->unit =  $record['unit'];
        $this->costEstimationDetail->quantity = $record['quantity'];
        $this->costEstimationDetail->rate = $record['rate'];
        $this->costEstimationDetail->amount = $record['amount'];
        $this->costEstimationDetail->vat_amount = $record['vat_amount'];
        $this->is_vatable = $record['vat_amount'] > 0;
        $this->editingIndex = $index;
    }
    public function toggleField()
    {
        if ($this->is_vatable) {
            $this->recalculateVat();
        } else {
            $this->costEstimationDetail->vat_amount = null;
        }
    }

    public function toggleIsRevised()
    {
        if ($this->is_revised) {
            $this->revision_no += 1;
            $this->revision_date = now()->format('Y-m-d');
        } else {
            $this->revision_no = null;
            $this->revision_date = null;
        }
    }
    public function recalculateVat(): void
    {
        $detail = $this->costEstimationDetail;
        if (isset($detail->quantity) && isset($detail->rate)) {
            $this->costEstimationDetail->amount = $detail->quantity * $detail->rate;
            if ($this->is_vatable) {
                $this->costEstimationDetail->vat_amount = $detail->amount * 0.13;
            }
        }
    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Yojana.yojana.cost-estimation'),
                file: $file,
                disk: getStorageDisk('private'),
                filename: ""
            );

            //            $this->costEstimation->{$modelField} = $save;

            //            dd($save, $this->costEstimation, $modelField, $this->image );
            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Yojana.yojana.cost-estimation'),
                filename: $save,
                disk: getStorageDisk('private')
            );

            if ($save) {
                return $save;
            } else {
                $this->errorFlash('yojana::messages.file_could_not_be_uploaded');
            }
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->costEstimation?->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Yojana.yojana.cost-estimation'),
                    filename: $this->costEstimation->{$modelField},
                    disk: getStorageDisk('private')
                );
            }
        }
    }

    public function updatedRateAnalysisDocument()
    {
        $saved_image = $this->handleFileUpload($this->rate_analysis_document, 'rate_analysis_document', 'rate_analysis_document_url');
        $this->rate_analysis_saved = $saved_image;
    }
    public function updatedCostEstimationDocument()
    {
        $saved_image = $this->handleFileUpload($this->cost_estimation_document, 'cost_estimation_document', 'cost_estimation_document_url');
        $this->cost_estimation_saved = $saved_image;
    }
    public function updatedInitialPhoto()
    {
        $saved_image = $this->handleFileUpload($this->initial_photo, 'initial_photo', 'initial_photo_url');
        $this->initial_photo_saved = $saved_image;
    }

    public function loadData()
    {
        $this->plan =  $this->plan->refresh();
        $this->costEstimation = $this->plan->costEstimation;
        $this->records = $this->costEstimation?->costEstimationDetail?->whereNull('deleted_at')->toArray() ?? [];
        $this->configRecords = $this->costEstimation?->configDetails?->whereNull('deleted_at')->toArray() ?? [];
        $this->costRecords = $this->costEstimation?->costDetails?->whereNull('deleted_at')->toArray() ?? [];
        $this->revision_no = $this->costEstimation?->revision_no ?? 0;
        $this->revision_date = $this->costEstimation?->revision_date;
        $this->action = Action::UPDATE;

        $this->recalculateTotalAmount();
        $this->calculateConfigAmount();
        $this->recalculateTotalCost();


        $this->handleFileUpload(null, 'rate_analysis_document', 'rate_analysis_document_url');
        $this->handleFileUpload(null, 'cost_estimation_document', 'cost_estimation_document_url');
        $this->handleFileUpload(null, 'initial_photo', 'initial_photo_url');
    }

    protected function secondaryRules()
    {
        return [
            'records' => 'required|array|min:1',
        ];
    }


    public function save()
    {
        if (count((array)$this->records) < 1){
            $this->errorFlash(__('yojana::messages.please_add_cost_estimation_details_first'),'');
            return;
        }
        
        try {
            $this->costEstimation->rate_analysis_document = $this?->rate_analysis_saved ?? "";
            $this->costEstimation->cost_estimation_document = $this->cost_estimation_saved ?? "";
            $this->costEstimation->initial_photo =  $this->initial_photo_saved ?? "";
            DB::beginTransaction();
            $this->costEstimation->plan_id = $this->plan->id;
            $this->costEstimation->total_cost = $this->totalEstimatedAmount;
            if ($this->is_revised) {
                $this->costEstimation->is_revised = $this->is_revised;
                $this->costEstimation->revision_no = $this->revision_no;
                $this->costEstimation->revision_date = $this->revision_date;
            }
            $dto = CostEstimationAdminDto::fromLiveWireModel($this->costEstimation);
            $service = new CostEstimationAdminService();

            switch ($this->action) {
                case Action::CREATE:
                    $costEstimation = $service->store($dto);

                    $costEstimationDetailsService = new CostEstimationDetailAdminService();
                    $costEstimationConfigurationService = new CostEstimationConfigurationAdminService();
                    $costDetailsService = new CostDetailsAdminService();
                    $costEstimationDetailsService->sync($costEstimation->id, $this->records);
                    foreach ($this->configRecords as $record) {
                        $record['cost_estimation_id'] = $costEstimation->id;
                        $costEstimationConfigurationDto = CostEstimationConfigurationAdminDto::fromArrayData($record);
                        $costEstimationConfigurationService->store($costEstimationConfigurationDto);
                    }
                    foreach ($this->costRecords as $record) {
                        $record['cost_estimation_id'] = $costEstimation->id;
                        $costDetailDto = CostDetailsAdminDto::fromArrayData($record);
                        $costDetailsService->store($costDetailDto);
                    }

                    $this->plan->status = PlanStatus::CostEstimationEntry;
                    $this->plan->save();
                    DB::commit();
                    $this->action = Action::UPDATE;
                    $this->loadData();
                    $this->successFlash(__('yojana::yojana.cost_estimation_created_successfully'));
                    $this->dispatch('reload_page');
                    break;
                case Action::UPDATE:
                    $service->update($this->costEstimation, $dto);
                    $costEstimationDetailsService = new CostEstimationDetailAdminService();
                    $costEstimationConfigurationService = new CostEstimationConfigurationAdminService();
                    $costDetailsService = new CostDetailsAdminService();

                    //                    foreach ($this->records as $record) {
                    //                          $record['cost_estimation_id'] = $costEstimation->id;
                    //                        $costEstimationDetailsDto = CostEstimationDetailsAdminDto::fromArrayData($record);
                    //                        $costEstimationDetailsService->store($costEstimationDetailsDto);
                    //                    }

                    $costEstimationDetailsService->sync($this->costEstimation->id, $this->records);

                    $this->costEstimation->configDetails()->delete();
                    $this->costEstimation->costDetails()->delete();

                    foreach ($this->configRecords as $record) {
                        $record['cost_estimation_id'] = $this->costEstimation->id;
                        $costEstimationConfigurationDto = CostEstimationConfigurationAdminDto::fromArrayData($record);
                        $costEstimationConfigurationService->store($costEstimationConfigurationDto);
                    }

                    foreach ($this->costRecords as $record) {
                        $record['cost_estimation_id'] = $this->costEstimation->id;
                        $costDetailDto = CostDetailsAdminDto::fromArrayData($record);
                        $costDetailsService->store($costDetailDto);
                    }
                    $this->successFlash(__('yojana::yojana.cost_estimation_updated_successfully'));
                    DB::commit();
                    $this->dispatch('reload_page');
                    break;
            }
        } catch (ValidationException $e) {
            DB::rollBack();
            $this->errorFlash(__('yojana::yojana.unexpected_error_encountered_while_processing_your_request'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorFlash(__('yojana::yojana.unexpected_error_encountered_while_processing_your_request'));
        }
    }

    public function costEstimationPrint()
    {
        $estimation = $this->plan?->costEstimation;

        if (!$this->plan || !$estimation || !$estimation->id || !$estimation->exists) {
            $this->warningFlash(__('yojana::yojana.plan_or_cost_estimation_not_found'));
            return false;
        }


        $costEstimation = $this->plan->costEstimation;
        $plan = $this->plan;
        $plan->load(['implementationLevel']);


        $costEstimation->load(['costEstimationDetail.unitRelation', 'costDetails', 'configDetails', 'costEstimationDetail.activity']);
        $totalConfig = 0;
        foreach ($costEstimation->configDetails as $configDetail) {
            $totalConfig += $configDetail->amount;
        }

        $user = Auth::user();
        $ward = Ward::where('id', GlobalFacade::ward())->first();
        $palika_name = getSetting('palika-name');
        $palika_logo = getSetting('palika-logo');
        $palika_campaign_logo = getSetting('palika-campaign-logo');

        $address = getSetting('palika-district') . ', ' . getSetting('palika-province') . ', ' . 'नेपाल';
        $palika_ward = $ward ? $ward->ward_name_ne : getSetting('office_name');
        $nepaliDate = replaceNumbers($this->adToBs(now()->format('Y-m-d')), true);

        $html = view('Yojana::cost-estimation.print', compact('costEstimation',  'palika_name', 'palika_logo', 'palika_campaign_logo', 'address', 'palika_ward', 'nepaliDate', 'plan', 'totalConfig'))->render();
        $url = PdfFacade::saveAndStream(
            content: $html,
            file_path: config('src.Yojana.yojana.cost-estimation'),
            file_name: "token_{$user->email}" . date('YmdHis'),
                            disk: getStorageDisk('private'),
        );
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }

    public function printApprovalLetter()
    {
        $cacheKey = 'letter_sample_exists:' . LetterTypes::ProgramApprovalAndInformationLetter->value . ':' . $this->plan->implementation_method_id;
        $exists = LetterSample::where('letter_type', LetterTypes::ProgramApprovalAndInformationLetter)
                ->where('implementation_method_id', $this->plan->implementation_method_id)
                ->exists();

        if ($exists == false) {
            $this->errorFlash(__('yojana::messages.template_not_found'));
            return false;
        }
        $estimation = $this->plan?->costEstimation;

        if (!$this->plan || !$estimation || !$estimation->id || !$estimation->exists) {
            $this->warningFlash(__('yojana::yojana.plan_or_cost_estimation_not_found'));
            return false;
        }

        $service = new CostEstimationAdminService();
        $workOrder = $service->getWorkOrder($this->plan);
        $url = route('admin.plans.work_orders.preview', ['id' => $workOrder->id]);
        $this->dispatch('open-pdf-in-new-tab', url: $url);
    }
}
