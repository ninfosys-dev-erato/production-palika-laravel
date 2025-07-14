<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\BudgetSource;

class BudgetSourceAdminDto
{
   public function __construct(
        public string $title,
        public string $code,
        public string $level_id
    ){}

public static function fromLiveWireModel(BudgetSource $budgetSource):BudgetSourceAdminDto{
    return new self(
        title: $budgetSource->title,
        code: $budgetSource->code,
        level_id: $budgetSource->level_id
    );
}
}
