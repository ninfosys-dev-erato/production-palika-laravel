<?php

namespace Src\EmergencyContacts\DTO;

use Src\EmergencyContacts\Models\EmergencyContact;

class EmergencyServiceAdminDto
{
   public function __construct(
        public ?int $emergency_id,
        public ?string $contact_person,
        public ?string $contact_person_ne,
        public ?string $address,
        public ?string $address_ne,
        public ?string $contact_numbers,
        public ?string $site_map,
        public ?string $website_url,
        public ?string $facebook_url,
        public ?string $image,
    ){}

    public static function fromArray(array $data): self
{
    return new self(
        $data ['emergency_id'],
        $data['contact_person'],
        $data['contact_person_ne'],
        $data['address'],
        $data['address_ne'],
        $data['contact_numbers'],
        $data['site_map'],
        $data['website_url'],
        $data['facebook_url'],
        $data['image'],
    );
}

}
