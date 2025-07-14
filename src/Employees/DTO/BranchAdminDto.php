<?php

namespace Src\Employees\DTO;

use Src\Employees\Models\Branch;

class BranchAdminDto
{
    public function __construct(
        public string $title,
        public string $title_en,
    ){}

    public static function fromLiveWireModel(Branch $branch):BranchAdminDto{
        return new self(
            title: $branch->title,
            title_en: $branch->title_en,
        );
    }
}
