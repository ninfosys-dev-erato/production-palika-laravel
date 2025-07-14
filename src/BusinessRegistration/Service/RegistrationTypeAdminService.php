<?php

namespace Src\BusinessRegistration\Service;

use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\RegistrationTypeAdminDto;
use Src\BusinessRegistration\Models\RegistrationType;

class RegistrationTypeAdminService
{

    public function store(RegistrationTypeAdminDto $regTypeDto): bool|RegistrationType
    {
        $regType = RegistrationType::create([
            'title' => $regTypeDto->title,
            'form_id' => $regTypeDto->form_id,
            'registration_category_id' => $regTypeDto->registration_category_id,
            'department_id' => $regTypeDto->department_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'action' => $regTypeDto->action,
        ]);

        return $regType;
    }

    public function update(RegistrationTypeAdminDto $regTypeDto, RegistrationType $registrationType): bool|RegistrationType
    {
        $regType = tap($registrationType)->update([
            'title' => $regTypeDto->title,
            'form_id' => $regTypeDto->form_id,
            'registration_category_id' => $regTypeDto->registration_category_id,
            'department_id' => $regTypeDto->department_id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
            'action' => $regTypeDto->action,
        ]);

        return $regType;
    }

    public function delete(RegistrationType $registrationType): bool|RegistrationType
    {
        $regType = tap($registrationType)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id
        ]);

        return $regType;
    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        RegistrationType::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
