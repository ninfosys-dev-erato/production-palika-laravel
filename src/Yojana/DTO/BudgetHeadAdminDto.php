<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\BudgetHead;

class BudgetHeadAdminDto
{
    public function __construct(
        public string $title
    ) {}

    public static function fromLiveWireModel(BudgetHead $budgetHead): BudgetHeadAdminDto
    {
        return new self(
            title: $budgetHead->title
        );
    }
}
