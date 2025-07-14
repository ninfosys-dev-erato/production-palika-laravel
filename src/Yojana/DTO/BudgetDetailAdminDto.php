<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\BudgetDetail;

class BudgetDetailAdminDto
{
   public function __construct(
        public string $ward_id,
        public string $amount,
        public string $program
    ){}

public static function fromLiveWireModel(BudgetDetail $budgetDetail):BudgetDetailAdminDto{
    return new self(
        ward_id: $budgetDetail->ward_id,
        amount: $budgetDetail->amount,
        program: $budgetDetail->program
    );
}
}
