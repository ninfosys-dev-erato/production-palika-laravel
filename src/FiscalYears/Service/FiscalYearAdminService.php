<?php

namespace Src\FiscalYears\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Src\FiscalYears\DTO\FiscalYearAdminDto;
use Src\FiscalYears\Models\FiscalYear;

class FiscalYearAdminService
{
    public function store(FiscalYearAdminDto $fiscalYearAdminDto)
    {
        Cache::forget('fiscalYear');
        return FiscalYear::create([
            'year' => $fiscalYearAdminDto->year,
            'created_by' => Auth::id(),
        ]);

    }

    public function update(FiscalYear $fiscalYear, FiscalYearAdminDto $fiscalYearAdminDto)
    {
        Cache::forget('fiscalYear');
        return tap($fiscalYear)->update([
            'year' => $fiscalYearAdminDto->year,
            'updated_by' => Auth::id(),
        ]);

    }

    public function delete(FiscalYear $fiscalYear)
    {
        Cache::forget('fiscalYear');
        return tap($fiscalYear)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        Cache::forget('fiscalYear');
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        FiscalYear::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);


    }
}


