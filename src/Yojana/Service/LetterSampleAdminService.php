<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\LetterSampleAdminDto;
use Src\Yojana\Models\LetterSample;

class LetterSampleAdminService
{
    public function store(LetterSampleAdminDto $letterSampleAdminDto)
    {
        return LetterSample::create([
            'letter_type' => $letterSampleAdminDto->letter_type,
            'implementation_method_id' => $letterSampleAdminDto->implementation_method_id,
            'name' => $letterSampleAdminDto->name,
            'subject' => $letterSampleAdminDto->subject,
            'sample_letter' => $letterSampleAdminDto->sample_letter,
            'styles' => $letterSampleAdminDto->styles,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(LetterSample $letterSample, LetterSampleAdminDto $letterSampleAdminDto)
    {
        return tap($letterSample)->update([
            'letter_type' => $letterSampleAdminDto->letter_type,
            'implementation_method_id' => $letterSampleAdminDto->implementation_method_id,
            'name' => $letterSampleAdminDto->name,
            'subject' => $letterSampleAdminDto->subject,
            'sample_letter' => $letterSampleAdminDto->sample_letter,
            'styles' => $letterSampleAdminDto->styles,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(LetterSample $letterSample)
    {
        return tap($letterSample)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        LetterSample::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
