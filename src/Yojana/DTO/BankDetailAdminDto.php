<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\BankDetail;

class BankDetailAdminDto
{
   public function __construct(
        public string $title,
        public string $branch
    ){}

public static function fromLiveWireModel(BankDetail $bankDetail):BankDetailAdminDto{
    return new self(
        title: $bankDetail->title,
        branch: $bankDetail->branch
    );
}
}
