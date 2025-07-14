<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ConsumerCommitteeTransaction;

class ConsumerCommitteeTransactionAdminDto
{
   public function __construct(
        public string $project_id,
        public string $type,
        public string $date,
        public string $amount,
        public string $remarks
    ){}

public static function fromLiveWireModel(ConsumerCommitteeTransaction $consumerCommitteeTransaction):ConsumerCommitteeTransactionAdminDto{
    return new self(
        project_id: $consumerCommitteeTransaction->project_id,
        type: $consumerCommitteeTransaction->type,
        date: $consumerCommitteeTransaction->date,
        amount: $consumerCommitteeTransaction->amount,
        remarks: $consumerCommitteeTransaction->remarks
    );
}
}
