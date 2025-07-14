<?php

namespace Src\Yojana\Service;

use App\Traits\SessionFlash;
use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\WorkOrderAdminDto;
use Src\Yojana\Enums\LetterTypes;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\Plan;
use Src\Yojana\Models\WorkOrder;
use Src\Yojana\Traits\YojanaTemplate;

class WorkOrderAdminService
{
    use YojanaTemplate, SessionFlash;
public function store(WorkOrderAdminDto $workOrderAdminDto){
    return WorkOrder::create([
        'date' => $workOrderAdminDto->date,
        'plan_id' => $workOrderAdminDto->plan_id,
        'plan_name' => $workOrderAdminDto->plan_name,
        'subject' => $workOrderAdminDto->subject,
        'letter_body' => $workOrderAdminDto->letter_body,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(WorkOrder $workOrder, WorkOrderAdminDto $workOrderAdminDto){
    return tap($workOrder)->update([
        'date' => $workOrderAdminDto->date,
        'plan_id' => $workOrderAdminDto->plan_id,
        'plan_name' => $workOrderAdminDto->plan_name,
        'subject' => $workOrderAdminDto->subject,
        'letter_body' => $workOrderAdminDto->letter_body,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(WorkOrder $workOrder){
    return tap($workOrder)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    WorkOrder::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function workOrderLetter(LetterTypes $types , Plan $plan){
    $letterSample = LetterSample::where('letter_type', $types)
        ->where('implementation_method_id', $plan->implementation_method_id)
        ->first();
    if (!isset($letterSample)) {
        return null; // or handle gracefully
    }
    $workOrder = $plan->workOrders()
        ->where('letter_sample_id', $letterSample->id)
        ->first();
    if (!$workOrder) {
        $letterBody = $this->resolveTemplate($plan, $letterSample) ?? "";
        $workOrder = $plan->workOrders()->create([
            'date' => now()->toDateString(),
            'plan_id' => $plan->id,
            'plan_name' => $plan->project_name,
            'subject' => $letterSample->subject,
            'letter_body' => $letterSample?->styles . $letterBody,
            'letter_sample_id' => $letterSample->id,
        ]);
    }
    return $workOrder;

}

}


