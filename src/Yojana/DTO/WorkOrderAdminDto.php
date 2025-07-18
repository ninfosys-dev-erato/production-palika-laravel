<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\WorkOrder;

class WorkOrderAdminDto
{
   public function __construct(
        public string $date,
        public string $plan_id,
        public string $plan_name,
        public string $subject,
        public string $letter_body
    ){}

public static function fromLiveWireModel(WorkOrder $workOrder):WorkOrderAdminDto{
    return new self(
        date: $workOrder->date,
        plan_id: $workOrder->plan_id,
        plan_name: $workOrder->plan_name,
        subject: $workOrder->subject,
        letter_body: $workOrder->letter_body ?? ''
    );
}
}
