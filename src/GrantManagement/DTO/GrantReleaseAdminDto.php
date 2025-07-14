<?php

namespace Src\GrantManagement\DTO;

use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;
use Src\GrantManagement\Models\GrantRelease;
use Ramsey\Uuid\Guid\Guid;

class GrantReleaseAdminDto
{
    public function __construct(
        public ?string $grantee_name = "",
        public string $grantee_type,
        public string $grantee_id,
        public string $investment,
        public string $is_new_or_ongoing,
        public string $last_year_investment,
        public string $plot_no,
        public string $location,  // Changed from location
        public string $contact_person,
        public string $contact_no,
        public string $condition,
        public string $grant_program
    ) {}

    public static function fromLivewireModel(GrantRelease $grantRelease): GrantReleaseAdminDto
    {
        return new self(
            grantee_name: $grantRelease?->grantee?->grantee_name ?? "N/A",
            grantee_type: $grantRelease->grantee_type,
            grantee_id: $grantRelease->grantee_id,
            investment: $grantRelease->investment,
            is_new_or_ongoing: $grantRelease->is_new_or_ongoing,
            last_year_investment: $grantRelease->last_year_investment,
            plot_no: $grantRelease->plot_no,
            location: $grantRelease->location,
            contact_person: $grantRelease->contact_person,
            contact_no: $grantRelease->contact_no,
            condition: $grantRelease->condition,
            grant_program: $grantRelease->grant_program
        );
    }
}
