<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\ConsumerCommitteeMemberDesgination;
use Src\Yojana\Models\ConsumerCommitteeMember;

class ConsumerCommitteeMemberAdminDto
{
    public function __construct(
        public string $consumer_committee_id,
        public string $citizenship_number,
        public string $name,
        public string $gender,
        public string $father_name,
        public ?string $husband_name,
        public ?string $grandfather_name,
        public ?string $father_in_law_name,
        public ?bool $is_monitoring_committee,
        public ConsumerCommitteeMemberDesgination $designation,
        public string $address,
        public string $mobile_number,
        public ?bool $is_account_holder,
        public ?string $citizenship_upload
    ) {}

    public static function fromLiveWireModel(ConsumerCommitteeMember $consumerCommitteeMember): ConsumerCommitteeMemberAdminDto
    {
        return new self(
            consumer_committee_id: $consumerCommitteeMember->consumer_committee_id,
            citizenship_number: $consumerCommitteeMember->citizenship_number,
            name: $consumerCommitteeMember->name,
            gender: $consumerCommitteeMember->gender,
            father_name: $consumerCommitteeMember->father_name,
            husband_name: $consumerCommitteeMember->husband_name,
            grandfather_name: $consumerCommitteeMember->grandfather_name,
            father_in_law_name: $consumerCommitteeMember->father_in_law_name,
            is_monitoring_committee: $consumerCommitteeMember->is_monitoring_committee ?? false,
            designation: $consumerCommitteeMember->designation,
            address: $consumerCommitteeMember->address,
            mobile_number: $consumerCommitteeMember->mobile_number,
            is_account_holder: $consumerCommitteeMember->is_account_holder ?? false,
            citizenship_upload: $consumerCommitteeMember->citizenship_upload
        );
    }
}
