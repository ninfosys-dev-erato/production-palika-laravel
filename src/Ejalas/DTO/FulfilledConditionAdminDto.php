<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\FulfilledCondition;

class FulfilledConditionAdminDto
{
   public function __construct(
        public string $complaint_registration_id,
        public string $fulfilling_party,
        public string $condition,
        public string $completion_details,
        public string $completion_proof,
        public string $due_date,
        public string $completion_date,
        public string $entered_by,
        public string $entry_date
    ){}

public static function fromLiveWireModel(FulfilledCondition $fulfilledCondition):FulfilledConditionAdminDto{
    return new self(
        complaint_registration_id: $fulfilledCondition->complaint_registration_id,
        fulfilling_party: $fulfilledCondition->fulfilling_party,
        condition: $fulfilledCondition->condition,
        completion_details: $fulfilledCondition->completion_details,
        completion_proof: $fulfilledCondition->completion_proof,
        due_date: $fulfilledCondition->due_date,
        completion_date: $fulfilledCondition->completion_date,
        entered_by: $fulfilledCondition->entered_by,
        entry_date: $fulfilledCondition->entry_date
    );
}
}
