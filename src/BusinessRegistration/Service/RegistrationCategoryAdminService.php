<?php

namespace Src\BusinessRegistration\Service;

use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\RegistrationCategoryAdminDto;
use Src\BusinessRegistration\Models\RegistrationCategory;

class RegistrationCategoryAdminService
{

    public function store(RegistrationCategoryAdminDto $dto): bool|RegistrationCategory
    {
        $registrationCategory = RegistrationCategory::create([
            'title' => $dto->title,
            'title_ne' => $dto->title_ne,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);

        return $registrationCategory;
    }

    public function update(RegistrationCategory $registrationCategory, RegistrationCategoryAdminDto $dto): bool|RegistrationCategory
    {
        $registrationCategory = tap($registrationCategory)->update([
            'title' => $dto->title,
            'title_ne' => $dto->title_ne,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);

        return $registrationCategory;
    }

    public function delete(RegistrationCategory $registrationCategory): bool|RegistrationCategory
    {
        $registrationCategory = tap($registrationCategory)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id
        ]);

        return $registrationCategory;
    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        RegistrationCategory::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function getRegistrationCategory()
    {
        return RegistrationCategory::with('registrationTypes')->select('id', 'title')->get();
    }
}
