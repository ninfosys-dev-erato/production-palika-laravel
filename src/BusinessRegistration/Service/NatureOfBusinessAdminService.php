<?php

namespace Src\BusinessRegistration\Service;

use Illuminate\Support\Facades\Auth;
use Src\BusinessRegistration\DTO\NatureOfBusinessAdminDto;
use Src\BusinessRegistration\Models\NatureOfBusiness;

class NatureOfBusinessAdminService
{

    public function store(NatureOfBusinessAdminDto $dto): bool|NatureOfBusiness
    {
        $natureOfBusiness = NatureOfBusiness::create([
            'title' => $dto->title,
            'title_ne' => $dto->title_ne,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);

        return $natureOfBusiness;
    }

    public function update(NatureOfBusiness $natureOfBusiness, NatureOfBusinessAdminDto $dto): bool|NatureOfBusiness
    {
        $natureOfBusiness = tap($natureOfBusiness)->update([
            'title' => $dto->title,
            'title_ne' => $dto->title_ne,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);

        return $natureOfBusiness;
    }

    public function delete(NatureOfBusiness $natureOfBusiness): bool|NatureOfBusiness
    {
        $natureOfBusiness = tap($natureOfBusiness)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id
        ]);

        return $natureOfBusiness;
    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        NatureOfBusiness::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
