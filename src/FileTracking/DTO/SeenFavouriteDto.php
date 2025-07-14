<?php

namespace Src\FileTracking\DTO;

use Illuminate\Support\Facades\Auth;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\SeenFavourite;

class SeenFavouriteDto
{
    public function __construct(
        public ?int $file_record_id,
        // public ?string $status,
        public ?bool $is_favourite,
        public ?bool $is_archived,
        public ?string $user_type,
        // public ?int $priority,
        public ?bool $is_chalani,
        public ?int $user_id,
       
    ) {}

    public static function fromModel( SeenFavourite $seenFavourite, FileRecord $fileRecord): self
    {
        $userType = Auth::guard('customer')->user()
            ?? Auth::guard('api-customer')->user()
            ?? Auth::guard('web')->user();
       
        return  new self(
            file_record_id: $fileRecord->id,
            // status: $fileRecord->status,
            is_favourite: (bool) $seenFavourite->is_favourite ?? false,
            is_archived: (bool) $seenFavourite->is_archived ?? false,
            user_type: get_class($userType),
            user_id: $userType->id,
            // priority: $fileRecord->priority,
            is_chalani: (bool) $fileRecord->is_chalani,
        );

       

    }
}
