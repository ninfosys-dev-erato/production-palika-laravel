<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\ConsumerCommittee;

class ConsumerCommitteeAdminDto
{
   public function __construct(
        public string $committee_type_id,
        public string $registration_number,
        public string $formation_date,
        public string $name,
        public string $ward_id,
        public string $address,
        public string $creating_body,
        public string $bank_id,
        public string $account_number,
        public ?string $formation_minute,
        public string $number_of_attendees
    ){}

public static function fromLiveWireModel(ConsumerCommittee $consumerCommittee):ConsumerCommitteeAdminDto{
    return new self(
        committee_type_id: $consumerCommittee->committee_type_id,
        registration_number: $consumerCommittee->registration_number,
        formation_date: $consumerCommittee->formation_date,
        name: $consumerCommittee->name,
        ward_id: $consumerCommittee->ward_id,
        address: $consumerCommittee->address,
        creating_body: $consumerCommittee->creating_body,
        bank_id: $consumerCommittee->bank_id,
        account_number: $consumerCommittee->account_number,
        formation_minute: $consumerCommittee->formation_minute,
        number_of_attendees: $consumerCommittee->number_of_attendees,
    );
}
}
