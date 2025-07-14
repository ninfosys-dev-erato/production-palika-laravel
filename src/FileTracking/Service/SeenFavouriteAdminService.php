<?php

namespace Src\FileTracking\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Src\FileTracking\DTO\SeenFavouriteDto;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\SeenFavourite;

class SeenFavouriteAdminService
{
    public function updateArchived(SeenFavouriteDto $seenFavouriteDto)
    {
        return SeenFavourite::updateOrCreate(
            ['file_record_id' => $seenFavouriteDto->file_record_id], 
            [
                'is_favourite' => $seenFavouriteDto->is_favourite,
                'is_archived' => $seenFavouriteDto->is_archived,
                'user_type' => $seenFavouriteDto->user_type,
                'user_id' => $seenFavouriteDto->user_id,
                'is_chalani' => $seenFavouriteDto->is_chalani,
            ]
        );
    }
    public function updateFavourite(SeenFavouriteDto $seenFavouriteDto)
    {
        return SeenFavourite::updateOrCreate(
            ['file_record_id' => $seenFavouriteDto->file_record_id], 
            [
                'is_favourite' => $seenFavouriteDto->is_favourite,
                'is_archived' => $seenFavouriteDto->is_archived,
                'user_type' => $seenFavouriteDto->user_type,
                'user_id' => $seenFavouriteDto->user_id,
                'is_chalani' => $seenFavouriteDto->is_chalani,
            ]
        );
    }

    public function toggleFavourite(FileRecord $fileRecord, Authenticatable $user):bool
    {
        $favourite = SeenFavourite::firstOrNew([
            'file_record_id' => $fileRecord->id,
            'user_id' => $user->id,
            'user_type' => get_class($user),
        ]);

        $favourite->is_favourite = !$favourite->is_favourite;
        $favourite->save();
        return  $favourite->is_favourite;
    }

}
