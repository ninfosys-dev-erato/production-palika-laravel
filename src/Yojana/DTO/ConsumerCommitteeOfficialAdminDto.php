<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ConsumerCommitteeOfficial;

class ConsumerCommitteeOfficialAdminDto
{
   public function __construct(
        public string $consumer_committee_id,
        public string $post,
        public string $name,
        public string $father_name,
        public string $grandfather_name,
        public string $address,
        public string $gender,
        public string $phone,
        public string $citizenship_no
    ){}

public static function fromLiveWireModel(ConsumerCommitteeOfficial $consumerCommitteeOfficial):ConsumerCommitteeOfficialAdminDto{
    return new self(
        consumer_committee_id: $consumerCommitteeOfficial->consumer_committee_id,
        post: $consumerCommitteeOfficial->post,
        name: $consumerCommitteeOfficial->name,
        father_name: $consumerCommitteeOfficial->father_name,
        grandfather_name: $consumerCommitteeOfficial->grandfather_name,
        address: $consumerCommitteeOfficial->address,
        gender: $consumerCommitteeOfficial->gender,
        phone: $consumerCommitteeOfficial->phone,
        citizenship_no: $consumerCommitteeOfficial->citizenship_no
    );
}
}
