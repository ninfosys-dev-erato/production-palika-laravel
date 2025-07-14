<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\TestList;

class TestListAdminDto
{
   public function __construct(
        public string $title,
        public string $type,
        public bool $is_for_agreement
    ){}

public static function fromLiveWireModel(TestList $testList):TestListAdminDto{
    return new self(
        title: $testList->title,
        type: $testList->type,
        is_for_agreement: $testList->is_for_agreement
    );
}
}
