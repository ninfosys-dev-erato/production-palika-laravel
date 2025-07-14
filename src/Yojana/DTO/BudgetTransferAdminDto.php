<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\BudgetTransfer;

class BudgetTransferAdminDto
{
    public function __construct(
        public string $from_plan,
        public string $to_plan,
        public string $amount,
    ){}

    public static function fromLiveWireModel(BudgetTransfer $budgetTransfer):BudgetTransferAdminDto{
        return new self(
            from_plan: $budgetTransfer->from_plan,
            to_plan: $budgetTransfer->to_plan,
            amount: $budgetTransfer->amount
        );
    }
}
