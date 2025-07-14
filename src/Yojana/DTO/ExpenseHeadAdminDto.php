<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ExpenseHead;

class ExpenseHeadAdminDto
{
   public function __construct(
        public string $title,
        public string $code,
        public string $type
    ){}

public static function fromLiveWireModel(ExpenseHead $expenseHead):ExpenseHeadAdminDto{
    return new self(
        title: $expenseHead->title,
        code: $expenseHead->code,
        type: $expenseHead->type
    );
}
}
