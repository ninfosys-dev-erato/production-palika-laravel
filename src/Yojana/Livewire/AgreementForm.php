<?php

namespace Src\Yojana\Livewire;

use AllowDynamicProperties;
use App\Enums\Action;
use App\Traits\SessionFlash;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Src\Employees\Models\Branch;
use Src\Employees\Models\Employee;
use Src\Yojana\Controllers\AgreementAdminController;
use Src\Yojana\DTO\AgreementAdminDto;
use Src\Yojana\DTO\AgreementBeneficiaryAdminDto;
use Src\Yojana\DTO\AgreementGrantAdminDto;
use Src\Yojana\DTO\AgreementInstallmentDetailsAdminDto;
use Src\Yojana\DTO\AgreementSignatureDetailAdminDto;
use Src\Yojana\DTO\CostDetailsAdminDto;
use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Enums\SignatureParties;
use Src\Yojana\Models\Agreement;
use Src\Yojana\Models\AgreementBeneficiary;
use Src\Yojana\Models\AgreementGrant;
use Src\Yojana\Models\AgreementSignatureDetail;
use Src\Yojana\Models\Application;
use Src\Yojana\Models\BenefitedMember;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\ConsumerCommitteeMember;
use Src\Yojana\Models\CostDetails;
use Src\Yojana\Models\CostEstimation;
use Src\Yojana\Models\Evaluation;
use Src\Yojana\Models\ImplementationMethod;
use Src\Yojana\Models\Organization;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\SourceType;
use Src\Yojana\Service\AgreementAdminService;
use Src\Yojana\Service\AgreementBeneficiaryAdminService;
use Src\Yojana\Service\AgreementGrantAdminService;
use Src\Yojana\Service\AgreementInstallmentDetailAdminService;
use Src\Yojana\Service\AgreementSignatureDetailAdminService;
use Src\Yojana\Service\CostDetailsAdminService;

class AgreementForm extends Component
{
    use SessionFlash;

    public ?Plan $plan;
    public ?Agreement $agreement;
    public ?Action $action;
    public $consumerCommittees;
    public $implementationMethods;
    public $beneficiaries;
    public $sourceTypes;
    public $model;
    public $organizations;
    public $applications;

    public CostEstimation $costEstimation;
    public costDetails $costDetails;
    public AgreementGrant $agreementGrant;
    public AgreementBeneficiary $agreementBeneficiary;
    public AgreementSignatureDetail $agreementSignatureDetail;

    public $costRecords = [];
    public $grantRecords = [];
    public $beneficiaryRecords = [];
    public $signatureRecords = [];
    public $installmentDetails = [];

    public bool $basedOnWorkProgress = false;

    protected $listeners = ['loadAgreement'];
    /**
     * @var SignatureParties[]
     */
    public $signatureParties;
    /**
     * @var true
     */
    public bool $isOption = false;
    public $partyNames;
    public bool $isImplementationAgency;
    public bool $isDepositRequired = false;

    public function rules(): array
    {
        return array_merge(
            $this->agreementRules(),
            $this->installmentRules(),
            $this->costRules(),
            $this->grantRules(),
            $this->beneficiaryRules(),
            $this->signatureRules()
        );
    }

    protected function agreementRules(): array
    {
        return [
            'agreement.plan_id' => ['required'],
            'agreement.consumer_committee_id' => ['required'],
            'agreement.implementation_method_id' => ['required'],
            'agreement.plan_start_date' => ['required'],
            'agreement.plan_completion_date' => ['required'],
            'agreement.experience' => ['required'],
            'agreement.deposit_number' => ['nullable','numeric','min:1'],
        ];
    }

    protected function costRules(): array
    {
        return [
            'costDetails.cost_source' => 'required',
            'costDetails.cost_amount' => 'required|numeric|min:1',
        ];
    }

    protected function grantRules(): array
    {
        return [
            'agreementGrant.source_type_id' => 'required',
            'agreementGrant.material_name' => 'required',
            'agreementGrant.unit' => 'required',
            'agreementGrant.amount' => 'required|numeric|min:1',
        ];
    }

    protected function beneficiaryRules(): array
    {
        return [
            'agreementBeneficiary.beneficiary_id' => 'required',
            'agreementBeneficiary.total_count' => 'required|numeric|min:1',
            'agreementBeneficiary.men_count' => 'required|numeric|min:1',
            'agreementBeneficiary.women_count' => 'required|numeric|min:1',
        ];
    }

    protected function signatureRules(): array
    {
        return [
            'agreementSignatureDetail.signature_party' => 'nullable',
            'agreementSignatureDetail.name' => 'required',
            'agreementSignatureDetail.position' => 'nullable',
            'agreementSignatureDetail.address' => 'required',
            'agreementSignatureDetail.contact_number' => 'required|numeric|digits:10',
            'agreementSignatureDetail.date' => 'required',
        ];
    }

    protected function installmentRules(): array
    {
        return [
            'installmentDetails.*.release_date' => ['required'],
            'installmentDetails.*.cash_amount' => ['required', 'numeric', 'min:0'],
            'installmentDetails.*.goods_amount' => ['required', 'numeric', 'min:0'],
            'installmentDetails.*.percentage' => ['required', 'numeric', 'between:0,100'],
        ];
    }

    public function render()
    {
        return view("Yojana::livewire.agreements-form");
    }

    public function mount(
        ?Plan $plan = null,
        ?Agreement $agreement = null,
        ?Action $action = null,
        ?CostDetails $costDetails = null,
        ?AgreementGrant $agreementGrant = null,
        ?AgreementBeneficiary $agreementBeneficiary = null,
        ?AgreementSignatureDetail $agreementSignatureDetail = null
    ) {
        $this->plan = $plan ?? new Plan();
        $this->agreement = $agreement ?? new Agreement();
        $this->action = $action ?? Action::CREATE;
        $this->costDetails = $costDetails ?? new CostDetails();
        $this->agreementGrant = $agreementGrant ?? new AgreementGrant();
        $this->agreementBeneficiary = $agreementBeneficiary ?? new AgreementBeneficiary();
        $this->agreementSignatureDetail = $agreementSignatureDetail ?? new AgreementSignatureDetail();

//        $this->basedOnWorkProgress = false;

        if ($this->plan->costEstimation) {
            $this->costEstimation = $this->plan->costEstimation;
            $this->costRecords = $this->costEstimation->costDetails->toArray() ?? [];
        } else {
            $this->costEstimation = new CostEstimation();
            $this->costRecords = [];
        }

        $this->consumerCommittees = ConsumerCommittee::whereNull('deleted_at')->pluck('name', 'id')->toArray();
        $this->implementationMethods = ImplementationMethod::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->sourceTypes = SourceType::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->beneficiaries = BenefitedMember::whereNull('deleted_at')->pluck('title', 'id')->toArray();
        $this->signatureParties = SignatureParties::cases();


        $this->plan->load('implementationMethod', 'implementationAgency.organization', 'implementationAgency.consumerCommittee.committeeMembers', 'implementationAgency.application');

        $this->model = $this->plan->implementationMethod->model;

        $this->agreement->implementation_method_id = $plan->implementationMethod->id;
        if (
            $this->model == ImplementationMethods::OperatedByNGO ||
            $this->model == ImplementationMethods::OperatedByQuotation ||
            $this->model == ImplementationMethods::OperatedByContract
        ) {
            $this->organizations = Organization::whereNull('deleted_at')->pluck('name', 'id')->toArray();
            $this->agreement->consumer_committee_id = $this->plan->implementationAgency->organization_id;
        } elseif ($this->model == ImplementationMethods::OperatedByConsumerCommittee) {

            $this->agreement->consumer_committee_id = $this->plan->implementationAgency->consumer_committee_id;
        } elseif ($this->model == ImplementationMethods::OperatedByTrust) {
            $this->applications = Application::whereNull('deleted_at')->pluck('applicant_name', 'id')->toArray();
            $this->agreement->consumer_committee_id = $this->plan->implementationAgency->application_id;
        }
    }

    public function addCostRecord()
    {
        $data = $this->validate($this->costRules());
        $this->costRecords[] = $data['costDetails'];
        $this->costDetails = new CostDetails();
    }

    public function removeCostRecord($index)
    {
        $this->removeRecord($this->costRecords, $index);
    }
    public function addGrantRecord()
    {
        $data = $this->validate($this->grantRules());
        $this->grantRecords[] = $data['agreementGrant'];
        $this->agreementGrant = new AgreementGrant();
    }

    public function removeGrantRecord($index)
    {
        $this->removeRecord($this->grantRecords, $index);
    }

    public function addBeneficiaryRecord()
    {
        $data = $this->validate($this->beneficiaryRules());
        $this->beneficiaryRecords[] = $data['agreementBeneficiary'];
        $this->agreementBeneficiary = new AgreementBeneficiary();
    }

    public function removeBeneficiaryRecord($index)
    {
        $this->removeRecord($this->beneficiaryRecords, $index);
    }

    public function addSignatureRecord()
    {
        $data = $this->validate($this->signatureRules());
        $this->signatureRecords[] = $data['agreementSignatureDetail'];
        $this->agreementSignatureDetail = new AgreementSignatureDetail();
    }

    public function removeSignatureRecord($index)
    {
        $this->removeRecord($this->signatureRecords, $index);
    }

    protected function removeRecord(&$records, $index)
    {
        unset($records[$index]);
        $records = array_values($records);
    }

    #[On('loadAgreement')]
    public function loadAgreement($id)
    {
        $this->agreement = Agreement::with(['grants', 'beneficiaries', 'signatureDetails', 'installmentDetails'])->findOrFail($id);
        $this->grantRecords = $this->agreement->grants?->toArray() ?? [];
        $this->beneficiaryRecords = $this->agreement->beneficiaries?->toArray() ?? [];
        $this->signatureRecords = $this->agreement->signatureDetails?->toArray() ?? [];
        $this->installmentDetails = $this->agreement->installmentDetails?->toArray() ?? [];
        $this->isDepositRequired = !empty($this->agreement->deposit_number);
        $this->action = Action::UPDATE;
        $this->dispatch('open-editAgreement');
    }

    public function toggleInstallmentTable()
    {
        $this->basedOnWorkProgress = !$this->basedOnWorkProgress;
    }

    public function toggleDepositField()
    {
        $this->isDepositRequired = !$this->isDepositRequired;
    }


    public function save()
    {
        $this->agreement->plan_id = $this->plan->id;
        try {
            $this->validate(array_merge(
                $this->agreementRules(),
                $this->installmentRules()
            ));
            $dto = AgreementAdminDto::fromLiveWireModel($this->agreement);
            $service = new AgreementAdminService();

            DB::beginTransaction();

            switch ($this->action) {
                case Action::CREATE:

                    $agreement = $service->store($dto);
                    $this->saveRecords($agreement);

                    $this->plan->status = PlanStatus::AgreementCompleted;
                    $this->plan->save();

                    DB::commit();
                    $this->successFlash(__('yojana::yojana.agreement_created_successfully'));
                    $this->dispatch('reload_page');

                    break;
                case Action::UPDATE:

                    $agreement = $service->update($this->agreement, $dto);
                    $this->saveRecords($agreement);

                    DB::commit();
                    $this->successFlash(__('yojana::yojana.agreement_updated_successfully'));
                    $this->dispatch('reload_page');
                    break;
                default:
                    //                    return redirect()->route('admin.agreements.index');
                    break;
            }
            //            $this->dispatch('resetForm', 'open-agreementTable');
            $this->dispatch('reset-form-agreement');
            $this->dispatch('open-agreementTable');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            $this->errorFlash(collect($e->errors())->flatten()->first());
        }
    }

    public function loadParty($value)
    {
        $this->isImplementationAgency = false;

        switch ($value) {
            case SignatureParties::ImplementationAgency->value:
                if (
                    $this->model == ImplementationMethods::OperatedByNGO ||
                    $this->model == ImplementationMethods::OperatedByQuotation ||
                    $this->model == ImplementationMethods::OperatedByContract
                ) {
                    $organization = $this->plan->implementationAgency->organization;
                    $this->agreementSignatureDetail->name = $organization->representative;
                    $this->agreementSignatureDetail->position = $organization->post;
                    $this->agreementSignatureDetail->address = $organization->representative_address;
                    $this->agreementSignatureDetail->contact_number = $organization->mobile_number;
                    $this->isOption = false;

                } elseif ($this->model == ImplementationMethods::OperatedByConsumerCommittee) {
                    $committee = $this->plan->implementationAgency->consumerCommittee;
                    $members =  $committee->committeeMembers;
                    $this->partyNames = $members;
                    $this->isOption = true;

                } elseif ($this->model == ImplementationMethods::OperatedByTrust) {
                    $applicant = $this->plan->implementationAgency->application;
                    $this->agreementSignatureDetail->name = $applicant->applicant_name;
                    $this->agreementSignatureDetail->address = $applicant->address;
                    $this->agreementSignatureDetail->contact_number = $applicant->mobile_number;
                    $this->isOption = false;
                }
                $this->isImplementationAgency = true;
                break;
            case SignatureParties::Ward->value:
                $wardMembers = Employee::where('id', $this->plan->ward->id)->get();
                $this->partyNames = $wardMembers->load('designation');
                $this->isOption = true;
                break;
            case SignatureParties::PlanningDepartment->value:
                $planningDepartment = Employee::where('branch_id', 10 )->get();
                $this->partyNames = $planningDepartment->load('designation');
                $this->isOption = true;
                break;
            case SignatureParties::Office->value:
                $employees = Employee::all();
                $this->partyNames = $employees->load('designation');
                $this->isOption = true;
                break;
            default:
                $this->isOption = false;
                break;
        }
    }

    public function loadDetails($id)
    {
        if ($this->isImplementationAgency) {
            $committeeMember = ConsumerCommitteeMember::find($id);
            $this->agreementSignatureDetail->name = $committeeMember->name;
            $this->agreementSignatureDetail->position = $committeeMember?->designation?->label();
            $this->agreementSignatureDetail->address = $committeeMember->address;
            $this->agreementSignatureDetail->contact_number = $committeeMember->mobile_number;
        }
        else {
            $employee = Employee::find($id)->load('designation');
            $this->agreementSignatureDetail->name = $employee->name;
            $this->agreementSignatureDetail->position = $employee?->designation?->title;
            $this->agreementSignatureDetail->address = $employee->address;
            $this->agreementSignatureDetail->contact_number = $employee->phone;
        }
    }


    public function saveRecords($agreement)
    {

        $costService = new CostDetailsAdminService();
        $grantService = new AgreementGrantAdminService();
        $beneficiaryService = new AgreementBeneficiaryAdminService();
        $signatureService = new AgreementSignatureDetailAdminService();
        $installmentService = new AgreementInstallmentDetailAdminService();

        $agreement->grants()->delete();
        $agreement->beneficiaries()->delete();
        $agreement->signatureDetails()->delete();
        $agreement->installmentDetails()->delete();

        if ($this->costEstimation) {
            $this->costEstimation->costDetails()->delete();
        }
        foreach ($this->costRecords as $costRecord) {
            $costRecord['cost_estimation_id'] = $this->costEstimation->id;
            $costDto = CostDetailsAdminDto::fromArrayData($costRecord);
            $costService->store($costDto);
        }
        foreach ($this->grantRecords as $grantRecord) {
            $grantRecord['agreement_id'] = $agreement->id;
            $grantDto = AgreementGrantAdminDto::fromArrayData($grantRecord);
            $grantService->store($grantDto);
        }
        foreach ($this->beneficiaryRecords as $beneficiaryRecord) {
            $beneficiaryRecord['agreement_id'] = $agreement->id;
            $beneficiaryDto = AgreementBeneficiaryAdminDto::fromArrayData($beneficiaryRecord);
            $beneficiaryService->store($beneficiaryDto);
        }
        foreach ($this->signatureRecords as $signatureRecord) {
            $signatureRecord['agreement_id'] = $agreement->id;
            $signatureDto = AgreementSignatureDetailAdminDto::fromArrayData($signatureRecord);
            $signatureService->store($signatureDto);
        }
        foreach ($this->installmentDetails as $index => $installmentDetail) {
            $installmentDetail['agreement_id'] = $agreement->id;
            $installmentDetail['installment_number'] = $index + 1;
            $installmentDto = AgreementInstallmentDetailsAdminDto::fromArrayData($installmentDetail);
            $installmentService->store($installmentDto);
        }
    }

    #[On('reset-form-agreement')]
    public function resetForm()
    {
        $this->agreement = new Agreement();
        $this->grantRecords = [];
        $this->beneficiaryRecords = [];
        $this->signatureRecords =  [];
        $this->installmentDetails = [];
        $this->action = Action::CREATE;
    }
}
