<?php

namespace Src\Employees\Service;

use Illuminate\Support\Facades\Auth;
use Src\Employees\DTO\BranchAdminDto;
use Src\Employees\Models\Branch;
use Src\FiscalYears\Models\FiscalYear;

class BranchAdminService
{
    public function store(BranchAdminDto $branchAdminDto)
    {
        return Branch::create([
            'title' => $branchAdminDto->title,
            'title_en' => $branchAdminDto->title_en,
            'created_by' => Auth::id(),
        ]);

    }

    public function update(Branch $branch, BranchAdminDto $branchAdminDto)
    {
        return tap($branch)->update([
            'title' => $branchAdminDto->title,
            'title_en' => $branchAdminDto->title_en,
            'updated_by' => Auth::id(),
        ]);

    }

    public function delete(Branch $branch)
    {
        return tap($branch)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Branch::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);


    }

}
