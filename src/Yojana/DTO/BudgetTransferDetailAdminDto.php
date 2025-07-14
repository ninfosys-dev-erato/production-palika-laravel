<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Activity;
use Src\Yojana\Models\BudgetTransferDetails;

class BudgetTransferDetailAdminDto
{
    public function __construct(
        public string $budget_transfer_id,
        public string $budget_source_id,
        public string $amount,
    ) {}

    public static function fromLiveWireModel(BudgetTransferDetails $budgetTransferDetails): BudgetTransferDetailAdminDto
    {
        return new self(
            budget_transfer_id: $budgetTransferDetails->budget_transfer_id,
            budget_source_id: $budgetTransferDetails->budget_source_id,
            amount: $budgetTransferDetails->amount,
        );
    }
}
