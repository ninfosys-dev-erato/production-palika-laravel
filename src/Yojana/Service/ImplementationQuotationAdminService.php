<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ImplementationQuotationAdminDto;
use Src\Yojana\Models\ImplementationQuotation;

class ImplementationQuotationAdminService
{
    public function store(ImplementationQuotationAdminDto $implementationQuotationDto){
        return ImplementationQuotation::create([
            'implementation_agency_id' => $implementationQuotationDto->implementation_agency_id,
            'name' => $implementationQuotationDto->name,
            'address' => $implementationQuotationDto->address,
            'amount' => $implementationQuotationDto->amount,
            'date' => $implementationQuotationDto->date,
            'percentage' => $implementationQuotationDto->percentage,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(ImplementationQuotation $implementationQuotation, ImplementationQuotationAdminDto $implementationQuotationDto){
        return tap($implementationQuotation)->update([
            'implementation_agency_id' => $implementationQuotationDto->implementation_agency_id,
            'name' => $implementationQuotationDto->name,
            'address' => $implementationQuotationDto->address,
            'amount' => $implementationQuotationDto->amount,
            'date' => $implementationQuotationDto->date,
            'percentage' => $implementationQuotationDto->percentage,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(ImplementationQuotation $implementationQuotation){
        return tap($implementationQuotation)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        ImplementationQuotation::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


