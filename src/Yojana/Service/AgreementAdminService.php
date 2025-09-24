<?php

namespace Src\Yojana\Service;

use App\Facades\PdfFacade;
use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementAdminDto;
use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Models\Agreement;
use Src\Yojana\Models\AgreementFormat;
use Src\Yojana\Models\Plan;
use Src\Yojana\Traits\YojanaTemplate;

class AgreementAdminService
{
    use YojanaTemplate;
public function store(AgreementAdminDto $agreementAdminDto){
    return Agreement::updateOrCreate([
        'plan_id' => $agreementAdminDto->plan_id],[
        'consumer_committee_id' => $agreementAdminDto->consumer_committee_id,
        'implementation_method_id' => $agreementAdminDto->implementation_method_id,
        'plan_start_date' => $agreementAdminDto->plan_start_date,
        'plan_completion_date' => $agreementAdminDto->plan_completion_date,
        'experience' => $agreementAdminDto->experience,
        'deposit_number' => $agreementAdminDto->deposit_number,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Agreement $agreement, AgreementAdminDto $agreementAdminDto){
    return tap($agreement)->update([
        'plan_id' => $agreementAdminDto->plan_id,
        'consumer_committee_id' => $agreementAdminDto->consumer_committee_id,
        'implementation_method_id' => $agreementAdminDto->implementation_method_id,
        'plan_start_date' => $agreementAdminDto->plan_start_date,
        'plan_completion_date' => $agreementAdminDto->plan_completion_date,
        'experience' => $agreementAdminDto->experience,
        'deposit_number' => $agreementAdminDto->deposit_number,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Agreement $agreement){
    return tap($agreement)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Agreement::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}

    public function printAgreement($id)
    {
        $agreement = Agreement::find($id);
        $plan = $agreement->plan;
        $plan->load('costEstimation.costDetails.sourceType','agreement.implementationMethod','agreement.consumerCommittee.ward','agreement.grants.sourceType','agreement.beneficiaries.beneficiary','agreement.signatureDetails','agreement.agreementCost','agreement.installmentDetails');
        $implementationMethod = $plan->agreement->implementationMethod->model;

//        dd($plan->agreement->consumerCommittee);
//        if ($implementationMethod == ImplementationMethods::OperatedByConsumerCommittee){
//            $plan->setRelation('implementationAgency',$plan->)
//        }
        $agreement =  AgreementFormat::where('implementation_method_id',$plan->implementation_method_id)->first();
        if(!isset($agreement)){
            return null;
        };

        // $url = PdfFacade::saveAndStream(
        //     content: $this->resolveTemplate($plan,$agreement),
        //     file_path: config('src.Yojana.yojana.certificate'),
        //     file_name: "yojana_{$plan->id}",
        //     disk: getStorageDisk('private'),
        //     styles: $agreement?->styles ?? ""
        // );

        // return $url;
        $html =$this->resolveTemplate($plan,$agreement);
        $html = $agreement->styles.$html;
        return $html;

    }
}


