<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\AgreementFormatAdminDto;
use Src\Yojana\Models\AgreementFormat;

class AgreementFormatAdminService
{
    public function store(AgreementFormatAdminDto $agreementFormatAdminDto)
    {
        return AgreementFormat::updateOrCreate([
            'implementation_method_id' => $agreementFormatAdminDto->implementation_method_id],
            [
                'name' => $agreementFormatAdminDto->name,
                'sample_letter' => $agreementFormatAdminDto->sample_letter,
                'styles' => $agreementFormatAdminDto->styles,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
        ]);
    }
    public function update(AgreementFormat $agreementFormat, AgreementFormatAdminDto $agreementFormatAdminDto)
    {
        return tap($agreementFormat)->update([
            'implementation_method_id' => $agreementFormatAdminDto->implementation_method_id,
            'name' => $agreementFormatAdminDto->name,
            'sample_letter' => $agreementFormatAdminDto->sample_letter,
            'styles' => $agreementFormatAdminDto->styles,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(AgreementFormat $agreementFormat)
    {
        return tap($agreementFormat)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        AgreementFormat::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
