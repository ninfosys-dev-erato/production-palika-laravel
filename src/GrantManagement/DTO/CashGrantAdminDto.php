<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\CashGrant;

class CashGrantAdminDto
{
    public function __construct(
        public ?string $name,
        public string $address,
        public string $age,
        public string $contact,
        public string $citizenship_no,
        public string $father_name,
        public string $grandfather_name,
        public string $helplessness_type_id,
        public string $cash,
        public ?string $file,
        public string $remark
    ) {}

    public static function fromLiveWireModel(CashGrant $cashGrant): CashGrantAdminDto
    {
        return new self(
            name: $cashGrant->name,
            address: $cashGrant->address,
            age: $cashGrant->age,
            contact: $cashGrant->contact,
            citizenship_no: $cashGrant->citizenship_no,
            father_name: $cashGrant->father_name,
            grandfather_name: $cashGrant->grandfather_name,
            helplessness_type_id: $cashGrant->helplessness_type_id,
            cash: $cashGrant->cash,
            file: $cashGrant->file,
            remark: $cashGrant->remark
        );
    }
}
