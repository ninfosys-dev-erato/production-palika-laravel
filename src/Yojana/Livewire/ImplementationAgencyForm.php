<?php

namespace Src\Yojana\Livewire;

use App\Enums\Action;
use App\Facades\FileFacade;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Src\Committees\Models\CommitteeType;
use Src\Yojana\DTO\AgreementBeneficiaryAdminDto;
use Src\Yojana\DTO\ImplementationAgencyAdminDto;
use Src\Yojana\DTO\ImplementationContractDetailsDto;
use Src\Yojana\DTO\ImplementationQuotationAdminDto;
use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Models\Application;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\ImplementationAgency;
use Src\Yojana\Models\ImplementationContractDetails;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Models\Organization;
use Src\Yojana\Models\Plan;
use Src\Yojana\Service\ImplementationAgencyAdminService;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Src\Yojana\Service\ImplementationContractDetailService;
use Src\Yojana\Service\ImplementationQuotationAdminService;

class ImplementationAgencyForm extends Component
{
    use SessionFlash, WithFileUploads;

    public ?ImplementationAgency $implementationAgency;
    public ?Action $action = Action::CREATE;
    public $plan;
    public $consumerCommittees;
    public $implementationMethods;
    public $applicationUrl;
    public $agreementApplicationFile;
    public $agreementRecommendationLetterFile;
    public $depositVoucherFile;
    public $agreementRecommendationLetterUrl;
    public $depositVoucherUrl;
    public $organizations;
    public $applications;

    public $contractDetails = [];
    public $quotations = [];

    public function rules(): array
    {
        return array_merge([
            'implementationAgency.plan_id' => ['required'],
            'implementationAgency.consumer_committee_id' => ['nullable'],
            'implementationAgency.organization_id' => ['nullable'],
            'implementationAgency.application_id' => ['nullable'],
            'implementationAgency.model' => ['required'],
            'implementationAgency.comment' => ['nullable'],
            'implementationAgency.agreement_application' => ['nullable'],
            'implementationAgency.agreement_recommendation_letter' => ['nullable'],
            'implementationAgency.deposit_voucher' => ['nullable'],
            'contractDetails' => ['nullable'],
        ], $this->dynamicRules());
    }

    public function messages(): array
    {
        return [
            'implementationAgency.plan_id.required' => __('yojana::yojana.plan_id_is_required'),
            'implementationAgency.consumer_committee_id.required' => __('yojana::yojana.consumer_committee_id_is_required'),
            'implementationAgency.model.required' => __('yojana::yojana.model_is_required'),
            'implementationAgency.comment.required' => __('yojana::yojana.comment_is_required'),
            'implementationAgency.agreement_application.nullable' => __('yojana::yojana.agreement_application_is_optional'),
            'implementationAgency.agreement_recommendation_letter.nullable' => __('yojana::yojana.agreement_recommendation_letter_is_optional'),
            'implementationAgency.deposit_voucher.nullable' => __('yojana::yojana.deposit_voucher_is_optional'),
        ];
    }

    public function dynamicRules(): array
    {
        $dynamicRules = [];
        $model = $this->plan?->implementationMethod?->model;

        switch ($model) {
            case ImplementationMethods::OperatedByConsumerCommittee:
                $dynamicRules['implementationAgency.consumer_committee_id'] = ['required'];
                break;

            case ImplementationMethods::OperatedByContract:
                $dynamicRules['implementationAgency.organization_id'] = ['required'];
                $dynamicRules['contractDetails.contract_number'] = ['required', 'numeric'];
                $dynamicRules['contractDetails.notice_date'] = ['required', 'string'];
                $dynamicRules['contractDetails.bid_acceptance_date'] = ['required', 'string'];
                $dynamicRules['contractDetails.bid_amount'] = ['required', 'numeric', 'min:0'];
                $dynamicRules['contractDetails.deposit_amount'] = ['required', 'numeric', 'min:0'];
                break;

            case ImplementationMethods::OperatedByQuotation:
                $dynamicRules['implementationAgency.organization_id'] = ['required'];
                $dynamicRules['quotations'] = ['required', 'array', 'min:3'];
                $dynamicRules['quotations.*.name'] = ['required', 'string', 'max:255'];
                $dynamicRules['quotations.*.address'] = ['required', 'string', 'max:255'];
                $dynamicRules['quotations.*.amount'] = ['required', 'numeric', 'min:0'];
                $dynamicRules['quotations.*.date'] = ['required', 'string'];
                $dynamicRules['quotations.*.percentage'] = ['required', 'numeric', 'between:0,100'];
                break;

            case ImplementationMethods::OperatedByNGO:
                $dynamicRules['implementationAgency.organization_id'] = ['required'];
                break;

            case ImplementationMethods::OperatedByTrust:
                $dynamicRules['implementationAgency.application_id'] = ['required'];
                break;
        }

        return $dynamicRules;
    }


    public function render()
    {
        return view("Yojana::livewire.implementation-agencies.form");
    }

    public function mount(Action $action, Plan $plan)
    {
        $plan->load(['implementationAgency', 'implementationMethod']);
        $this->implementationAgency = $plan->implementationAgency ?? new ImplementationAgency();
        $this->action = $action;

        $this->plan = $plan->load('implementationMethod');
        $this->consumerCommittees = ConsumerCommittee::whereNull('deleted_at')->pluck('name', 'id');
        $this->implementationMethods = ImplementationMethod::whereNull('deleted_at')->pluck('title', 'id');
        $this->organizations = Organization::whereNull('deleted_at')->pluck('name', 'id');
        $this->applications = Application::whereNull('deleted_at')->pluck('applicant_name', 'id');

        if ($action == Action::UPDATE) {
            $this->handleFileUpload(null, 'agreement_application', 'applicationUrl');
            $this->handleFileUpload(null, 'agreement_recommendation_letter', 'agreementRecommendationLetterUrl');
            $this->handleFileUpload(null, 'deposit_voucher', 'depositVoucherUrl');
        }

        $this->quotations = array_fill(0, 3, [
            'name' => '',
            'address' => '',
            'amount' => '',
            'date' => '',
            'percentage' => '',
        ]);
    }

    public function save()
    {
        $this->implementationAgency->plan_id = $this->plan->id;
        $this->implementationAgency->model = $this->plan?->implementationMethod->id;
        $model = $this->plan?->implementationMethod?->model;
        $validated = $this->validate();
        try {
            DB::beginTransaction();
            $dto = ImplementationAgencyAdminDto::fromLiveWireModel($this->implementationAgency);
            $service = new ImplementationAgencyAdminService();
            switch ($this->action) {
                case Action::CREATE:
                    $saved = $service->store($dto);

                    if (
                        isset($this->contractDetails) &&
                        $model == ImplementationMethods::OperatedByContract
                    ) {
                        $this->contractDetails['implementation_agency_id'] = $saved->id;
                        $contractDto = ImplementationContractDetailsDto::fromArrayData($this->contractDetails);
                        $contractService =  new ImplementationContractDetailService();
                        $contractService->store($contractDto);
                    }
                    //                dd($model,ImplementationMethods::operated_by_quotation, $model == ImplementationMethods::operated_by_quotation->value );
                    if ($model == ImplementationMethods::OperatedByQuotation) {
                        $this->saveQuotation($saved);
                    }
                    $this->plan->status = PlanStatus::ImplementationAgencyAppointed;
                    $this->plan->save();

                    DB::commit();
                    $this->successFlash(__('yojana::yojana.implementation_agency_created_successfully'));
                    $this->dispatch('close-modal', id: 'implementationBodyModal');
                    $this->dispatch('reload_page');
                    break;
                case Action::UPDATE:
                    $updated = $service->update($this->implementationAgency, $dto);

                    if (
                        isset($this->contractDetails) &&
                        $this->implementationAgency->model == ImplementationMethods::OperatedByContract
                    ) {
                        $this->contractDetails['implementation_agency_id'] = $updated->id;
                        $contractDto = ImplementationContractDetailsDto::fromArrayData($this->contractDetails);
                        $contractService =  new ImplementationContractDetailService();
                        $currentContract = ImplementationContractDetails::find($this->contractDetails['id']);
                        $contractService->update($currentContract, $contractDto);
                    }

                    if ($model == ImplementationMethods::OperatedByQuotation) {
                        $updated->quotations()->delete();
                        $this->saveQuotation($updated);
                    }

                    DB::commit();
                    $this->successFlash(__('yojana::yojana.implementation_agency_updated_successfully'));
                    $this->dispatch('close-modal', id: 'implementationBodyModal');
                    $this->dispatch('reload_page');
                    break;
                default:
                    // return redirect()->route('admin.implementation_agencies.index');
                    break;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            //            dd($e->errors());
            $this->errorFlash(collect($e->errors())->flatten()->first());
        } catch (\Exception $e) {
            DB::rollBack();
            //            dd($e->getMessage());
            $this->errorFlash(collect($e)->flatten()->first());
        }
    }

    public function saveQuotation($implementation_agency)
    {
        $quotationService =  new ImplementationQuotationAdminService();
        foreach ($this->quotations as $quotation) {
            $quotation['implementation_agency_id'] = $implementation_agency->id;
            $quotationDto = ImplementationQuotationAdminDto::fromArrayData($quotation);
            $quotationService->store($quotationDto);
        }
    }

    public function handleFileUpload($file = null, string $modelField, string $urlProperty)
    {
        if ($file) {
            $save = FileFacade::saveFile(
                path: config('src.Yojana.yojana.implementation_agency'),
                file: $file,
                disk: "local",
                filename: ""
            );

            $this->implementationAgency->{$modelField} = $save;
            $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                path: config('src.Yojana.yojana.implementation_agency'),
                filename: $save,
                disk: 'local'
            );
        } else {
            // If no file is provided (edit mode), load the existing file URL
            if ($this->implementationAgency->{$modelField}) {
                $this->{$urlProperty} = FileFacade::getTemporaryUrl(
                    path: config('src.Yojana.yojana.implementation_agency'),
                    filename: $this->implementationAgency->{$modelField},
                    disk: 'local'
                );
            }
        }
    }
    public function updatedAgreementApplicationFile()
    {
        $this->handleFileUpload($this->agreementApplicationFile, 'agreement_application', 'applicationUrl');
    }

    public function updatedAgreementRecommendationLetterFile()
    {
        $this->handleFileUpload($this->agreementRecommendationLetterFile, 'agreement_recommendation_letter', 'agreementRecommendationLetterUrl');
    }

    public function updatedDepositVoucherFile()
    {
        $this->handleFileUpload($this->depositVoucherFile, 'deposit_voucher', 'depositVoucherUrl');
    }

    public function addQuotation()
    {
        $this->quotations[] = [
            'name' => '',
            'address' => '',
            'amount' => '',
            'date' => '',
            'percentage' => '',
        ];
    }

    public function removeQuotation($index)
    {
        unset($this->quotations[$index]);
        $this->quotations = array_values($this->quotations); // reindex
    }


    #[On('edit-implementation-agencies')]
    public function editImplementationAgencies(ImplementationAgency $implementationAgency)
    {
        $this->implementationAgency = $implementationAgency->load('implementationContractDetail', 'quotations');
        $model = $this->plan?->implementationMethod?->model;

        if ($model == ImplementationMethods::OperatedByContract) {
            $this->contractDetails = $this->implementationAgency->implementationContractDetail->toArray();
        }
        if ($model == ImplementationMethods::OperatedByQuotation) {
            $this->quotations = $this->implementationAgency->quotations->toArray();
        }
        $this->action = Action::UPDATE;
        $this->handleFileUpload(null, 'agreement_application', 'applicationUrl');
        $this->handleFileUpload(null, 'agreement_recommendation_letter', 'agreementRecommendationLetterUrl');
        $this->handleFileUpload(null, 'deposit_voucher', 'depositVoucherUrl');
        $this->dispatch('open-modal', id: 'implementationBodyModal');
    }

    #[On('reset-form')]
    public function resetImplementation()
    {
        $this->reset(['implementationAgency', 'action']);
        $this->implementationAgency = new ImplementationAgency();
        $this->contractDetails = [];
        $this->quotations = array_fill(0, 3, [
            'name' => '',
            'address' => '',
            'amount' => '',
            'date' => '',
            'percentage' => '',
        ]);
    }
}
