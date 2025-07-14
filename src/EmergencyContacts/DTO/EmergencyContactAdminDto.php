<?php

namespace Src\EmergencyContacts\DTO;

use Src\EmergencyContacts\Enum\ContactPages;
use Src\EmergencyContacts\Models\EmergencyContact;

class EmergencyContactAdminDto
{
   public function __construct(
        public ContactPages $group,
        public ?string $parent_id,
        public ?string $service_name,
        public ?string $service_name_ne,
        public ?string $icon,
        public ?string $contact_person,
        public ?string $contact_person_ne,
        public ?string $address,
        public ?string $address_ne,
        public ?string $contact_numbers,
        public ?string $site_map,
        public ?string $content,
        public ?string $content_ne,
        public ?string $website_url,
        public ?string $facebook_url,
    ){}

public static function fromLiveWireModel(EmergencyContact $emergencyContact):EmergencyContactAdminDto{
    return new self(
        group: $emergencyContact->group ?? null,
        parent_id: $emergencyContact->parent_id,
        service_name: $emergencyContact->service_name ?? null,
        service_name_ne: $emergencyContact->service_name_ne ?? null,
        icon: $emergencyContact->icon ?? null,
        contact_person: $emergencyContact->contact_person ?? null,
        contact_person_ne: $emergencyContact->contact_person_ne ?? null,
        address: $emergencyContact->address ?? null,
        address_ne: $emergencyContact->address_ne ?? null,
        contact_numbers: $emergencyContact->contact_numbers ?? null,
        site_map: $emergencyContact->site_map ?? null,
        content: $emergencyContact->content ?? null,
        content_ne: $emergencyContact->content_ne ?? null,
        website_url: $emergencyContact->website_url ?? null,
        facebook_url: $emergencyContact->facebook_url ?? null
    );
}
}
