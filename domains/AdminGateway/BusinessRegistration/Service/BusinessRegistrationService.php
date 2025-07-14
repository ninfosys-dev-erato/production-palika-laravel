<?php

namespace Domains\AdminGateway\BusinessRegistration\Service;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Src\BusinessRegistration\Models\BusinessRegistration;

class BusinessRegistrationService
{
    public function businessRegistrationList() : Builder
    {
        $builder = BusinessRegistration::query()
            ->with(['registrationType.registrationCategory', 'province', 'district', 'localBody'])
            ->select('province_id',
                'district_id',
                'tole',
                'ward_no',
                'local_body_id',
                'entity_name',
                'registration_date',
                'application_date',
                'certificate_number',
                'registration_type_id',
                'registration_number',
                'application_status',
                'applicant_name',
                'applicant_number'
            )->where('brs_business_registration.deleted_at', null)
            ->whereNull(['brs_business_registration.deleted_at'])
            ->orderBy('brs_business_registration.created_at', 'desc');
        return $builder;
    }
}