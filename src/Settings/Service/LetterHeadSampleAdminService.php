<?php

namespace Src\Settings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Settings\DTO\LetterHeadSampleAdminDto;
use Src\Settings\Models\LetterHeadSample;

class LetterHeadSampleAdminService
{
    public function store(LetterHeadSampleAdminDto $letterHeadSampleAdminDto)
    {
        return LetterHeadSample::create([
            'name' => $letterHeadSampleAdminDto->name,
            'content' => $letterHeadSampleAdminDto->content,
            'slug' => $letterHeadSampleAdminDto->slug,
            'style' => $letterHeadSampleAdminDto->style,
            'created_by' => Auth::id(),
        ]);
    }

    public function update(LetterHeadSample $letterHeadSample, LetterHeadSampleAdminDto $letterHeadSampleAdminDto)
    {
        return tap($letterHeadSample)->update([
            'name' => $letterHeadSampleAdminDto->name,
            'content' => $letterHeadSampleAdminDto->content,
            'slug' => $letterHeadSampleAdminDto->slug,
            'style' => $letterHeadSampleAdminDto->style,
            'updated_by' => Auth::id(),
        ]);
    }

    public function delete(LetterHeadSample $letterHeadSample)
    {
        return $letterHeadSample->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        LetterHeadSample::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
