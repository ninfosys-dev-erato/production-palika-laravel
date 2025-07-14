<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Activity;
use Src\Yojana\Models\BudgetSourcePaymentLog;

class BudgetSourceLogDto
{
    public function __construct(
        public string $payment_id,
        public string $plan_budget_source_id,
        public string $amount,
    ) {}

    public static function fromLiveWireModel(BudgetSourcePaymentLog $budgetSourceLog): BudgetSourceLogDto
    {
        return new self(
            payment_id: $budgetSourceLog->payment_id,
            plan_budget_source_id: $budgetSourceLog->plan_budget_source_id,
            amount: $budgetSourceLog->amount,
        );
    }

    public static function fromArrayData(array $data): BudgetSourceLogDto
    {
        return new self(
            payment_id: $data['payment_id'],
            plan_budget_source_id: $data['plan_budget_source_id'],
            amount: $data['amount'],
        );
    }
}
