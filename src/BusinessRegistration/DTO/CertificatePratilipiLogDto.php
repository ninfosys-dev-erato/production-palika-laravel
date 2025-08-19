<?php

namespace Src\BusinessRegistration\DTO;

use App\Traits\HelperDate;
use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\Models\CertificatePratilipiLog;

class CertificatePratilipiLogDto
{
    use HelperDate;

    public function __construct(
        public ?int $user_id,
        public ?int $business_registration_id,
        public ?string $damage_reason,
        public ?string $entry_date,
        public ?int $created_by = null,
        public ?int $updated_by = null,
    ) {}

    public static function fromLiveWireModel(CertificatePratilipiLog $certificatePratilipiLog): self
    {
        return new self(
            user_id: Auth::user()?->id ?? Auth::guard('customer')->id(),
            business_registration_id: $certificatePratilipiLog->business_registration_id,
            damage_reason: $certificatePratilipiLog->damage_reason,
            entry_date: $certificatePratilipiLog->entry_date,
            created_by: Auth::user()?->id ?? Auth::guard('customer')->id(),
            updated_by: Auth::user()?->id ?? Auth::guard('customer')->id(),
        );
    }
}
