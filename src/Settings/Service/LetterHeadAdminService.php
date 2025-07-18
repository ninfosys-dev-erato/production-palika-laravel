<?php

namespace Src\Settings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Settings\DTO\LetterHeadAdminDto;
use Src\Settings\Models\LetterHead;

class LetterHeadAdminService
{
    public function store(LetterHeadAdminDto $letterHeadAdminDto)
    {
        return LetterHead::create([
            'header' => $letterHeadAdminDto->header,
            'footer' => $letterHeadAdminDto->footer,
            'created_by' => Auth::id(),
            'ward_no' => $letterHeadAdminDto->ward_no,
            'is_active' => $letterHeadAdminDto->is_active
        ]);

    }

    public function update(LetterHead $letterHead, LetterHeadAdminDto $letterHeadAdminDto)
    {
        return tap($letterHead)->update([
            'header' => $letterHeadAdminDto->header,
            'footer' => $letterHeadAdminDto->footer,
            'updated_by' => Auth::id(),
        ]);

    }

    public function delete(LetterHead $letterHead)
    {
        return $letterHead->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);

    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        LetterHead::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);


    }
}
