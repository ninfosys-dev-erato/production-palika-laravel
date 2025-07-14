<?php

namespace Src\Employees\Service;

use Illuminate\Support\Facades\Auth;
use Src\Employees\DTO\DesignationAdminDto;
use Src\Employees\Models\Designation;
use Src\FiscalYears\Models\FiscalYear;

class DesignationAdminService
{
    public function store(DesignationAdminDto $designationAdminDto)
    {
        return Designation::create([
            'title' => $designationAdminDto->title,
            'title_en' => $designationAdminDto->title_en,
            'created_by' => Auth::id(),
        ]);

    }

    public function update(Designation $designation, DesignationAdminDto $designationAdminDto)
    {
        return tap($designation)->update([
            'title' => $designationAdminDto->title,
            'title_en' => $designationAdminDto->title_en,
            'updated_by' => Auth::id(),
        ]);

    }

    public function delete(Designation $designation)
    {
        return tap($designation)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Designation::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);


    }
}
